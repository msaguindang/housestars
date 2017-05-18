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
use Response;
use Image;

class AgentController extends Controller
{
    public function dashboard(){
        $user_id =  Agents::where('agent_id', '=', Sentinel::getUser()->id)->first()->agency_id;

        $meta = UserMeta::where('user_id', $user_id)->get();
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

        $data['rating'] = $this->getRating($user_id);
        $data['reviews'] = $this->getReviews($user_id);
        $data['total'] = count($data['reviews']);

        $data['properties'] = $this->property_listing($user_id);
        $data['total-listings'] = count($data['properties']);
        // dd($data);
        return View::make('dashboard/agent/profile')->with('meta', $meta)->with('dp', $dp)->with('cp', $cp)->with('data', $data);
    }

    public function edit()
    {
        $user_id =  Agents::where('agent_id', '=', Sentinel::getUser()->id)->first()->agency_id;

        $meta = UserMeta::where('user_id', $user_id)->get();
        $data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';

        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }


        return View::make('dashboard/agent/edit')->with('data', $data);
    }

    public function updateProfile(Request $request)
    {

        //dd($request->all());
        if(Sentinel::check()){
            
            $user_id =  Agents::where('agent_id', '=', Sentinel::getUser()->id)->first()->agency_id;

            $meta_name = array('cover-photo', 'profile-photo', 'agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'base-commission', 'marketing-budget', 'sales-type', 'summary');

            foreach ($meta_name as $meta) {


                if ($request->hasFile($meta)) {
                    $localpath = 'user/user-'.$user_id.'/uploads';
                    $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$request->file($meta)->getClientOriginalExtension();
                    $path = $request->file($meta)->move(public_path($localpath), $filename);
                    $value = $localpath.'/'.$filename;
                    Image::make($value)->orientate()->save($value);
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

            return redirect(env('APP_URL').'/dashboard/agent/profile');

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

        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;

        return View::make('dashboard/agent/settings')->with('data', $data)->with('agents', $agents);
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



}
