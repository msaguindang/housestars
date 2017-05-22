<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserMeta;
use App\Reviews;
use App\User;
use App\Agents;
use App\Advertisement;
use App\Services\AgentService;
use App\Property;
use Response;
use View;
use Sentinel;

class ProfileController extends Controller
{
    public function profile($role, $id)
    {
        try {
        	switch ($role) {
        		case 'tradesman':
        			$data = $this->tradesman($id);
        			$data['suburbs'] = explode(',', $data['positions']);
        			$x = 0;
        			foreach($data['suburbs'] as $suburb) {
	        			$sub = preg_replace('/[0-9]/','',$suburb);
	        			$postcode = preg_replace('/\D/', '', $suburb);
	        			if($sub != '' || !empty($sub)){
		        			$data['position'][$x] = $postcode; 
							$x++;
	        			}
	        			
        			}
                    $data['id'] = $id;
                    $data['role'] = 'tradesman';
        			$data['name'] = User::find($id)->name;
                    return view('general.profile.tradesman-profile')->with('data', $data)->with('category', $role);
        			break;
                case 'agency':
                    $data = $this->agency($id);
                    $listings = $this->property_listing($id);
                    $data['property-listings'] = $listings;
                    $data['total-listings'] = count($listings);
                    $data['suburbs'] = isset($data['positions']) ? explode(',', $data['positions']) : [];
					$x = 0;
        			foreach ($data['suburbs'] as $suburb) {
	        			$sub = preg_replace('/[0-9]/','',$suburb);
	        			$postcode = preg_replace('/\D/', '', $suburb);
	        			if($sub != '' || !empty($sub)){
		        			$data['position'][$x] = $sub. ' ('. $postcode .')'; 
							$x++;
	        			}
        			}
                    $data['id'] = $id;
                    $data['role'] = 'agency';
                    $data['name'] = User::find($id)->name;
                    return view('general.profile.agency-profile')->with('data', $data)->with('category', $role);
                    break;
                case 'agent':
                    $data = app(AgentService::class)->getData($id);
                    $data['isOwner'] = false;
                    $data['id'] = $id;
                    $data['name'] = User::find($id)->name;
                    return View::make('dashboard/agent/profile')->with('meta', $data['meta'])->with('dp', $data['dp'])->with('cp', $data['cp'])->with('data', $data);
                    break;
                default:
                    abort(404);
                    break;
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function tradesman($id) {
    	$meta = UserMeta::where('user_id', $id)->get();
        $user = User::where('id', $id)->get();
    	$data = array();
        $data['tradesman-id'] = $id;
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
    	return $data;
    }

    public function agency($id) {
        $user = User::where('id', $id)->get();
        $meta = UserMeta::where('user_id', $id)->get();
        $data = array();
        $data['agency-id'] = $id;
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $data['email'] = $user[0]['email'];
        $x = 0; $y = 0;

        foreach ($meta as $key) {
            if($key->meta_name == 'gallery') {
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

    public function getReviews($id){

    	$reviews = Reviews::where('reviewee_id', '=', $id)->get();
    	$data = array(); $x = 0; $average = 0;
    	foreach ($reviews as $review) {

        if ($review->name == null && $user = User::where('id', $review->reviewer_id)->first()) {
          $data[$x]['name'] = $user->name;
        } else {
            $data[$x]['name'] = $review->name;
        }

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

    public function property_listing($id) {
        $property_meta = Property::where('meta_name', '=', 'agent')->where('user_id', '=', $id)->get();
        $x = 0;

        foreach ($property_meta as $meta) {
            $prop[$x]['id'] = $meta->user_id;
            $prop[$x]['code'] = $meta->property_code;
            $x++;
        }

        $properties = array();

        if(isset($prop)) {
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

    public function getPublicProfile($id)
    {
        if ($user = User::find($id)) {
            if ($role = $user->role) {
                $role_name = strtolower($role->definition->name);
                return redirect()->route('profile.role.id', ['role' => $role_name,'id' => $id]);
            }
        }
        return redirect('/');
    }

    public function editProfile(Request $request)
    {
        if (is_admin()) {
            $role = $request->route('role');
            $data = array();
            $data['id'] = $request->route('id');
            $data['profile-url'] = "profile/$role/{$data['id']}";
            switch ($role) {
                case 'agency':
                    return app(AgencyController::class)->edit($request);
                    break;
                case 'tradesman':
                    break;
                case 'agent':
                    $editData = app(AgentService::class)->getEditableData($data['id']);
                    return View::make('dashboard/agent/edit')->with('data', array_merge($data, $editData));
                    break;
                case 'customer':
                    return app(CustomerController::class)->edit($request);
                    break;
                default:
                    abort(404);
            }
        }
    }
}
