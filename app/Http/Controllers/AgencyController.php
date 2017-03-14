<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use View;
use Sentinel;
use App\User;
use App\UserMeta;
use App\Suburbs;
use Carbon\Carbon;
use Hash;
use App\Agents;
use App\Reviews;
use App\Property;
use App\Advertisement;
use Response;

class AgencyController extends Controller
{
    public function dashboard(){
        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $dp = 'assets/default.png';
        $cp = 'assets/default_cover_photo.jpg';
        foreach ($meta as $key) {
            if($key->meta_name == 'profile-photo'){
                $dp = $key->meta_value;
            } else if($key->meta_name == 'cover-photo'){
                $cp = $key->meta_value;
            } else {
                $data[$key->meta_name] = $key->meta_value;
            }
        }

        $data['rating'] = $this->getRating(Sentinel::getUser()->id);
        $data['reviews'] = $this->getReviews(Sentinel::getUser()->id);
        $data['total'] = count($data['reviews']);

        $data['properties'] = $this->property_listing(Sentinel::getUser()->id);
        $data['total-listings'] = count($data['properties']);

        $ads = Advertisement::where('type', '=', '270x270')->get();
        $y = 0;

        foreach ($ads  as $ad) {
            $advert[$ad->type][$y]['url'] = $ad->image_path;
            $y++;
        }

        if(isset($advert['270x270'])){
            $numAds =  count($advert['270x270']) - 1;
            $index1 = rand(0, $numAds);
            $data['advert'][0] = $advert['270x270'][$index1];
            $index2 = rand(0, $numAds);

            if($index1 == $index2){
                $index2 = rand(0, $numAds);
            }
            $data['advert'][1] = $advert['270x270'][$index2];

        }

        // dd($data);
        return View::make('dashboard/agency/profile')->with('meta', $meta)->with('dp', $dp)->with('cp', $cp)->with('data', $data);
    }

    public function edit()
    {

        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';

        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }


        return View::make('dashboard/agency/edit')->with('data', $data);
    }

    public function updateProfile(Request $request)
    {

        //dd($request->all());
        if(Sentinel::check()){
            $user_id = Sentinel::getUser()->id;

            $meta_name = array('cover-photo', 'profile-photo', 'agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'base-commission', 'marketing-budget', 'sales-type', 'summary');

            foreach ($meta_name as $meta) {


                if ($request->hasFile($meta)) {
                    $localpath = 'user/user-'.$user_id.'/uploads';
                    $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$request->file($meta)->getClientOriginalExtension();
                    $path = $request->file($meta)->move(public_path($localpath), $filename);
                    $value = $localpath.'/'.$filename;
                } else {
                    $value = $request->input($meta);
                }

                if($value !== null){
                    UserMeta::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => $meta],
                        ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                    );
                }

            }

            return redirect(env('APP_URL').'/dashboard/agency/profile');

        } else {
            return redirect('');
        }
    }

    public function settings()
    {

        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $agents = DB::table('users')
            ->join('agents', function ($join) {
                $join->on('users.id', '=', 'agents.agent_id')
                    ->where('agents.agency_id', '=', Sentinel::getUser()->id);
            })
            ->get();
        $data = array();


        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }

        if(Sentinel::getUser()->customer_id){
          \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");

          $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
        }


        $data['credit-card'] = (isset($customer_info) ? $customer_info->sources->data[0]->last4 : '');
        $data['expiry-month'] = (isset($customer_info) ? $customer_info->sources->data[0]->exp_month : '');
        $data['expiry-year'] = (isset($customer_info) ? $customer_info->sources->data[0]->exp_year : '');
        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;


        return View::make('dashboard/agency/settings')->with('data', $data)->with('agents', $agents);
    }

    public function updateSettings(Request $request)
    {
        if(Sentinel::check())
        {
            $id = Sentinel::getUser()->id;

            if($request->input('password') == ''){
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name')]);
            } else {
                $password = Hash::make($request->input('password'));
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name'), 'password' => $password]);
            }

            return redirect()->back();

        } else {
            return redirect(env('APP_URL'));
        }

    }

    public function updatePayment(Request $request)
    {
        if(Sentinel::check())
        {
            $customer_id = Sentinel::getUser()->customer_id;

            \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");

            try{

                if(Sentinel::getUser()->customer_id){
                  $token = \Stripe\Token::create(
                      array(
                          'card'=> array(
                              'number' => $request->input('credit-card'),
                              'exp_month' => $request->input('exp_month'),
                              'exp_year' => $request->input('exp_year'),
                              'cvc' => $request->input('cvc')
                          )
                      )
                  );

                    $customer = \Stripe\Customer::retrieve($customer_id);
                    $customer->source = $token; // obtained with Stripe.js
                    $customer->save();
                }

                User::where('id', $user_id)->update(['customer_id' => $customer->id]);
                return redirect()->back();

            }catch (\Stripe\Error\Card $e){

                $body = $e->getJsonBody();
                $err  = ''.$body['error']['message'].'';

                return redirect()->back()->with('error', $err);

            }


        } else {
            return redirect(env('APP_URL'));
        }

    }

    public function deleteAgent(Request $request)
    {
        if(Sentinel::check()){
            $id = $request->input('agent-id');
            User::where('id', '=', $id )->delete();
            Agents::where('agent_id', '=', $id )->delete();
            return redirect()->back();
        } else {
            return redirect(env('APP_URL'));
        }
    }

    public function updateAgent(Request $request)
    {
        if(Sentinel::check()){

            $agents = $request->input('add-agents');
            foreach ($agents as $agent) {
                if($agent['name'] != '' && $agent['email'] != ''){
                    if(isset($agent['id'])){

                        if($agent['password'] == ''){
                            User::updateOrCreate(
                                ['id' => $agent['id']],
                                ['id' => $agent['id'], 'email' => $agent['email'], 'name' => $agent['name']]);
                        } else {
                            $password = Hash::make($agent['password']);
                            User::updateOrCreate(
                                ['id' => $agent['id']],
                                ['id' => $agent['id'], 'email' => $agent['email'], 'name' => $agent['name'], 'password' => $password]);
                        }

                        if(isset($agent['active'])){
                            Agents::updateOrCreate(
                                ['agent_id' => $agent['id']],
                                ['agent_id' => $agent['id'], 'active' => 1]);
                        } else {
                            Agents::updateOrCreate(
                                ['agent_id' => $agent['id']],
                                ['agent_id' => $agent['id'], 'active' => 0]);
                        }
                    } else {
                        $credentials =  [
                            'email'    => $agent['email'],
                            'name'    => $agent['name'],
                            'password'    => $agent['password'],
                        ];

                        $user = Sentinel::registerAndActivate($credentials);
                        $role = Sentinel::findRoleBySlug('agent');
                        $role->users()->attach($user);
                        $email = [
                            'email' => $agent['email']
                        ];

                        $user_id = Sentinel::getUser()->id;
                        $agent_id = Sentinel::findByCredentials($email);

                        if(isset($agent['active'])){
                            Agents::firstOrCreate(['agent_id' => $agent_id['id'], 'agency_id' => $user_id, 'active' => 1]);
                        } else {
                            Agents::firstOrCreate(['agent_id' => $agent_id['id'], 'agency_id' => $user_id]);
                        }
                    }
                }
            }

            return redirect()->back();

        } else {
            return redirect(env('APP_URL'));
        }
    }

    public function getRating($id){
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);

        foreach ($ratings as $rating) {
            $average = ($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5)) / $numRatings;
        }

        return $average;
    }

    public function getReviews($id){

        $reviews = Reviews::where('reviewee_id', '=', $id)->get();
        $data = array(); $x = 0; $average = 0;
        foreach ($reviews as $review) {
            $name = User::where('id', $review->reviewer_id)->get();
            $data[$x]['name'] = $name[0]['name'];
            $data[$x]['average'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
            $data[$x]['communication'] = (int)$review->communication;
            $data[$x]['work_quality'] = (int)$review->work_quality;
            $data[$x]['price'] = (int)$review->price;
            $data[$x]['punctuality'] = (int)$review->punctuality;
            $data[$x]['attitude'] = (int)$review->attitude;
            $data[$x]['title'] = $review->title;
            $data[$x]['content'] = $review->content;
            $data[$x]['created'] = $review->created_at->format('M d, Y');
            $data[$x]['helpful'] = $review->helpful;
            $data[$x]['id'] = $review->id;
            $x++;
        }

        return $data;
    }
    public function helpful(Request $request){
        $review = Reviews::where('id', '=', $request->input('id'))->get();

        $data['count'] = $review[0]['helpful'] + 1;

        Reviews::where('id', '=', $request->input('id'))->update(['helpful' => $data['count']]);

        return Response::json($data, 200);
    }

    public function property_listing($id){
        $property_meta = Property::where('meta_name', '=', 'agent')->where('meta_value', '=', $id)->get();
        $x = 0;

        foreach ($property_meta as $meta) {
            $prop[$x]['id'] = $meta->user_id;
            $prop[$x]['code'] = $meta->property_code;
            $x++;
        }

        $properties = array();

        if(isset($prop)){
            foreach ($prop as $key) {
                $property = Property::where('user_id', '=', $key['id'])->where('property_code', '=', $key['code'])->get();
                foreach ($property as $meta) {
                    $info[$meta->meta_name] = $meta->meta_value;
                }

                array_push($properties, $info);
            }
        }


        return $properties;

    }

    public function getAgency(Request $request)
    {
        //if(Sentinel::check()){

        $userId = $request->input('agent');

        $userMeta = UserMeta::where('user_id', $userId);

        $neededMetas = $userMeta->whereIn('meta_name', [
            'agency-name',
            'principal-name',
            'business-address',
            'website',
            'phone',
            'abn',
            'positions'
        ])
            ->get()
            ->toArray();

        $agentProperties = [];

        foreach ($neededMetas as $meta) {
            $agentProperties[$meta['meta_name']] = $meta['meta_value'];
        }

        $response = [
            'id' => $userId,
            'metas' => $agentProperties
        ];

        return Response::json($response, 200);

        /*} else {
            $error['message'] = array('You are not authorized.');
            return Response::json($error, 422);
        }*/

    }

}
