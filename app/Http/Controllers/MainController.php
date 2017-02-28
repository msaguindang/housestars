<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Sentinel;
use App\Suburbs;
use App\Reviews;
use App\Role;
use App\UserMeta;

class MainController extends Controller
{
    function dashboard(){
    	if(Sentinel::check()){

            switch (Sentinel::getUser()->roles()->first()->slug){
                case 'agency':
                    return redirect(env('APP_URL').'/dashboard/agency/profile');
                    break;
                case 'tradesman':
                    return redirect(env('APP_URL').'/dashboard/tradesman/profile');
                    break;
                case 'customer':
                    return redirect(env('APP_URL').'/dashboard/customer/profile');
                    break;
                default: 
                    return redirect(URL::previous());
                    break;
            }

        } else { 
            return redirect(env('APP_URL'));
        }
    }

    function agency(){
        $data['suburbs'] = Suburbs::all();
        $reviews = Reviews::all();
        $data['comments'] = array();

        foreach ($reviews as $review) {
            // check if review is for housestars
            if($review->reviewee_id == 1){
                //Check if agency review
                $isAgency = Role::where('user_id', '=', $review->reviewer_id)->get();
                if(count($isAgency) > 0){
                // get review details
                    $review_details['average'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
                    $review_details['title'] = $review->title;
                    $review_details['content'] = $review->content;
                    $review_details['helpful'] = $review->helpful;
                // get reviewer details 
                    $user = UserMeta::where('user_id', '=', $review->reviewer_id)->get();
                    foreach ($user as $key) {
                        if($key->meta_name == 'agency-name'){
                            $review_details['name'] = $key->meta_value;
                        } else if($key->meta_name == 'profile-photo'){
                            $review_details['img'] = $key->meta_value;
                        }
                    }
                    
                    array_push($data['comments'], $review_details);
                
                }
            }
       }

       //dd($data);
        return view('general.agency')->with('data', $data);
    }
}
