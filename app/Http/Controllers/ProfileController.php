<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserMeta;
use App\Reviews;
use App\User;
use App\Advertisement;
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
            case 'agency':
                $data = $this->agency($id);
                //dd($data);
                return view('general.profile.agency-profile')->with('data', $data)->with('category', $role);
                break;
    		
    		default:
    			
    			break;
    	}
    }

    public function tradesman($id){
    	$meta = UserMeta::where('user_id', $id)->get();
        $user = User::where('id', $id)->get();
    	$data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $data['email'] = $user[0]['email'];
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
        //dd($data);
    	return $data; 
    }

    public function agency($id){
        $meta = UserMeta::where('user_id', $id)->get();
        $user = User::where('id', $id)->get();
        $data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $data['email'] = $user[0]['email'];
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
        //dd($data);
        return $data; 
    }

    public function getRating($id){
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);

        if($numRatings > 0){
            foreach ($ratings as $rating) {
                $average = ($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5)) / $numRatings;
            }
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
}
