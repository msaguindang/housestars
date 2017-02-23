<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserMeta;
use App\Reviews;
use App\User;
use Response;

class ProfileController extends Controller
{
    public function profile($role, $id){

    	switch ($role) {
    		case 'tradesman':
    			$data = $this->tradesman($id);
    			//dd($data);
    			return view('general.profile.tradesman-profile')->with('data', $data)->with('category', $role);
    			break;
    		
    		default:
    			
    			break;
    	}
    }

    public function tradesman($id){
    	$meta = UserMeta::where('user_id', $id)->get();
    	$data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $x = 0; $y = 0;

    	foreach ($meta as $key) {
    		if($key->meta_name == 'gallery'){
    			$data[$key->meta_name][$y] = $key->meta_value;
    			$y = $y + 1;

    		} else {
    			
    			$data[$key->meta_name] = $key->meta_value;
    		
    		}
    		
    	}

    	$data['rating'] = $this->getRating($id);
    	$data['reviews'] = $this->getReviews($id);
        $data['total'] = count($data['reviews']);
        //dd($data);
    	return $data; 
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
}
