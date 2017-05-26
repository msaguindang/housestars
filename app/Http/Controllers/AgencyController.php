<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
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
use Image;

class AgencyController extends Controller
{   
    const MAX_WIDTH_LANDSCAPE  = 1200,
          MAX_WIDTH_PORTRAIT  = 270,
          MAX_HEIGHT = 270;
          
    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function dashboard()
    {
        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $dp = 'assets/default.png';
        $cp = 'assets/default_cover_photo.jpg';
        $galleryCtr = 0;
        
        foreach ($meta as $key) {
            if ($key->meta_name == 'profile-photo') {
                $dp = $key->meta_value;
            } else if ($key->meta_name == 'cover-photo'){
                $cp = $key->meta_value;
            } else if ($key->meta_name == 'gallery') {
                $data[$key->meta_name][$galleryCtr] = $key->meta_value;
                $galleryCtr ++;
            } else {
                $data[$key->meta_name] = $key->meta_value;
            }
        }

        $data['rating'] = $this->getRating(Sentinel::getUser()->id);
        $data['reviews'] = $this->reviewService->getReviews(Sentinel::getUser()->id);
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
        

        return View::make('dashboard/agency/profile')->with('meta', $meta)->with('dp', $dp)->with('cp', $cp)->with('data', $data);
    }

    public function edit(Request $request)
    {
        $userId = is_admin() ? $request->route('id') : Sentinel::getUser()->id;
        $meta = UserMeta::where('user_id', $userId)->get();
        $data = array();
        $index = 0;
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';

        foreach ($meta as $key) {
            if($key->meta_name == 'gallery') {
                $data[$key->meta_name][$index] = array('id' => $key->id, 'url'=> $key->meta_value);
                $index ++;
            } else {
                $data[$key->meta_name] = $key->meta_value;
            }
        }
        $data['hasGallery'] = $index;
        $data['isAdmin'] = is_admin();
        $data['id'] = $userId;
        return View::make('dashboard/agency/edit')->with('data', $data);
    }

    public function updateProfile(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'profile-photo' => 'max:2048',
            'cover-photo'   => 'max:2048'
        ],[
            'profile-photo.max' => 'Profile photo should not be greater than 2MB.',
            'cover-photo.max'   => 'Cover photo should not be greater than 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else if(Sentinel::check() || is_admin()) {
            $user_id = $request->route('id') ? $request->route('id') : Sentinel::getUser()->id;

            $meta_name = array('cover-photo', 'profile-photo', 'agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'base-commission', 'marketing-budget', 'sales-type', 'summary');

            foreach ($meta_name as $meta) {
                if ($request->hasFile($meta)) {
                    $localpath = 'user/user-'.$user_id.'/uploads';
                    $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$request->file($meta)->getClientOriginalExtension();
                    $path = $request->file($meta)->move(public_path($localpath), $filename);
                    $value = $localpath . '/' . $filename;               
                    list($width, $height) = getimagesize($value);
                    $image = Image::make($value)->orientate();
                    $h = ($height > self::MAX_HEIGHT ? self::MAX_HEIGHT : $height);
                    if ($width > $height && $width > self::MAX_WIDTH_LANDSCAPE) {
                        // Landscape
                        $image->resize(self::MAX_WIDTH_LANDSCAPE, $h, function($c) {
                            $c->aspectRatio();
                            $c->upsize();
                        })->save($value);
                    } else if ($width < $height && $width > self::MAX_WIDTH_PORTRAIT) {
                        // Portrait or Square
                        $image->resize(self::MAX_WIDTH_PORTRAIT, $h, function($c) {
                            $c->aspectRatio();
                            $c->upsize();
                        })->save($value);
                    }

                } else if(!empty($request->get($meta.'-drag', ''))) {
                    $value = $request->input($meta.'-drag');
                } else {
                    $value = $request->input($meta);
                }

                if($value !== null) {
                    UserMeta::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => $meta],
                        ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                    );
                }

            }
			if(is_admin()){
				return redirect(env('APP_URL').'/profile/agency/' . $request->route('id'));
			} else{
				return redirect(env('APP_URL').'/dashboard/agency/profile');
			}

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
          \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

          $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
        }


        $data['credit-card'] = (isset($customer_info) ? $customer_info->sources->data[0]->last4 : '');
        $data['expiry-month'] = (isset($customer_info) ? $customer_info->sources->data[0]->exp_month : '');
        $data['expiry-year'] = (isset($customer_info) ? $customer_info->sources->data[0]->exp_year : '');
        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;
		//dd($agents);

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

            return redirect('/profile');

        } else {
            return redirect(env('APP_URL'));
        }

    }

    public function updatePayment(Request $request)
    {
        if(Sentinel::check())
        {

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            try{

                if ($customer_id = Sentinel::getUser()->customer_id) {
                    $user_id = Sentinel::getUser()->id;
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
                    User::where('id', $user_id)->update(['customer_id' => $customer->id]);
                }

                return redirect('/profile');

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
          //dd($request->all());
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
                            'password'    => $agent['password'],
                        ];

                        $user = Sentinel::registerAndActivate($credentials);
                        User::where('email', $user->email)->update(['name' => $agent['name']]);
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

     public function getRating($id) {
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);
		$rate = 0;
		$zero = 0; $one = 0; $two = 0; $three= 0; $four = 0; $five = 0;
		
        if($numRatings > 0){
            foreach ($ratings as $rating) {	
	            $ratingAverage = (int)round(($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5))); 
	            $rate = $rate + $ratingAverage;
            }
            $average =  (int)round($rate / $numRatings);
        }
		
        return $average;
    }

    public function helpful(Request $request){
        $review = Reviews::where('id', '=', $request->input('id'))->get();

        $data['count'] = $review[0]['helpful'] + 1;

        Reviews::where('id', '=', $request->input('id'))->update(['helpful' => $data['count']]);

        return Response::json($data, 200);
    }

    public function property_listing($id) {
        $property_meta = Property::where('meta_name', '=', 'agent')->where('user_id', '=', $id)->get();
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


    public function searchSuburb(Request $request)
    {
        $query = $request->input('query');

        $suburbs = Suburbs::where(DB::raw("CONCAT(suburbs.id,' ',suburbs.name)"), 'LIKE', "%{$query}%")
            ->select("suburbs.*", DB::raw("CONCAT(suburbs.id,'',suburbs.name) as value"))
            ->get()
            ->toArray();

        $response = [
            'request' => $request->all(),
            'suburbs' => $suburbs
        ];

        return Response::json($response, 200);
    }

    public function validateSuburbAvailability(Request $request)
    {
        $id = $request->input('data');

        $suburb = Suburbs::find($id);

        $valid = true;

        if($suburb->availability >= 3){
            $valid = false;
        }

        $response = [
            'request' => $request->all(),
            'valid' => $valid
        ];

        return Response::json($response, 200);
    }

    public function validateAvailability(Request $request)
    {
	    
        $data = $request->input('data');
		if(strpos($data,",") !== FALSE){
	        $data = explode(",", $data)[1];
	        if(strpos($data,'-dup') !== false){
	            $data = explode('-dup',$data)[0];
	        }
	    } else if(strpos($data,'-dup') !== false){
            $data = explode('-dup',$data)[0];
        }
    

        $suburb = Suburbs::where(DB::raw("CONCAT(suburbs.id,suburbs.name)"),'LIKE',"%{$data}%")->get()->first();
        $valid = true;

        // count number of traders per area

        if(!$suburb){
            $response = [
                'request' => $request->all(),
                'valid' => $valid,
                'suburb' => $suburb
            ];

            return Response::json($response, 200);
        }

        if ($suburb->availability == 3 ) {
            $valid = false;
        } 
        
        $response = [
            'request' => $request->all(),
            'valid' => $valid,
            'suburb' => $suburb
        ];

        return Response::json($response, 200);
    }
}
