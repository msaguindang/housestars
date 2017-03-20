<?php

namespace App\Http\Controllers;

use App\RoleUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Suburbs;
use App\UserMeta;
use App\User;
use App\Role;
use App\Category;
use Response;
use Mail;

class SearchController extends Controller
{
    public function search(Request $request, $item)
    {
    	switch ($item) {
    		case 'category':
    			$data['cat'] = Category::all();
                $data['suburb'] = $request->get('suburb', '');
                $data['item'] = $this->hasResults($data['suburb']);
    			// return Response::json($data, 200);
                return view('general.tradesman-listings')->with('data', $data);
    			break;
    		case 'agency':
                $data = $this->agencyListing($request->get('term', ''));
                return view('general.agency-listings')->with('data', $data);
                break;
    		default:
    			break;
    	}

    }

    public function hasResults($suburb)
    {
    	$suburbExists = UserMeta::where('meta_value', 'LIKE', '%'.$suburb.'%')->get();
    	$tradesmen = array();

    	foreach ($suburbExists as $key) {
            if($activeUser = User::where('id', '=', $key->user_id)->first()){
    			if ($activeUser->role && ($activeUser->role->role_id == 3)) {
    				$tradesman = $activeUser->usermetas->toArray(); //$activeUser->usermetas->where('meta_name', 'trade')->toArray();
                    if (!in_array($tradesman, $tradesmen)) {
    	    			array_push($tradesmen, $tradesman);
                    }
	    		}
            }
    	}

    	$data = array();

    	if (count($tradesmen) == 0) {
    		$data['msg'] = 'No result found for '. $suburb;
    		return $data;
    	}

    	foreach ($tradesmen as $key => $tradesman) {
            $mapped = collect($tradesman)->mapWithKeys(function ($item) {
                return [$item['meta_name'] => $item['meta_value']];
            });
            $mapped = $mapped->put('id', $tradesman[0]['user_id']);
            array_push($data, $mapped);
    	}
        
    	return $data;
    }

    public function tradesmenListing(Request $request)
    {
        $trade = UserMeta::where('meta_value', 'LIKE', '%'.$category.'%')->get();


        $tradesmen = array();

        foreach ($trade as $key) {
            $suburbExist = UserMeta::where('meta_value', 'LIKE', '%'.$suburb.'%')->where('user_id', '=', $key->user_id)->first();
            if(isset($suburbExist)){
              if($key->user_id == $suburbExist->user_id){
                  array_push($tradesmen, $key->user_id);
              }
            }
        }

        $data = array();
        $x = 0;
        foreach ($tradesmen as $id) {
           $activeUser = User::where('id', '=', $id)->get();
           if(count($activeUser) > 0){

                $tradesmanData = UserMeta::where('user_id', '=', $id)->get();
                foreach ($tradesmanData as $value) {
                   $data[$x][$value->meta_name] = $value->meta_value;
                }
                $data[$x]['rating'] = $this->getRating($id);
                $data[$x]['id'] = $value->user_id;
                $x++;
           }
        }

        $data['cat'] = $category;
        $data['suburb'] = $suburb;

       return view('general.tradesman-listings')->with('data', $data);
    }


    public function agencyListing($term)
    {
        //check if term has result
        $results = UserMeta::where('meta_value', 'LIKE', '%'.$term.'%')->get();
        // return no result

        if(count($results) == 0) {
            return $data['cat'] = $term;
        }
        //process result
        $agencies = [];

        foreach ($results as $result) {
            if(RoleUsers::hasRole($result->user_id, 2)) {
                if(!in_array($result->user_id, $agencies)) {
                    array_push($agencies, $result->user_id);
                }
            }
        }

        $x = 0;
        foreach ($agencies as $id) {
            $activeUser = User::where('id', '=', $id)->get();
            if(count($activeUser) > 0) {
                $agencyData = UserMeta::where('user_id', '=', $id)->get();
                foreach ($agencyData as $value) {
                if ($value->meta_name == 'summary') {
                    $data[$x][$value->meta_name] = substr($value->meta_value, 0, 150);
                } else {
                    $data[$x][$value->meta_name] = $value->meta_value;
                }

                }
                // $data[$x]['rating'] = $this->getRating($id);
                $data[$x]['id'] = $value->user_id;
                $x++;
           }
        }
        $data['cat'] = $term;
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

    public function send(Request $request, $type){

        switch ($type) {
            case 'tradesman':
                $this->sendEmail($request->input('name'), $request->input('contact'), 'emails.suggest-tradesman', null);
                return Response::json('success', 200);
                break;
            case 'category':
                $this->sendEmail($request->input('name'), $request->input('trade'), 'emails.suggest-category', $request->input('email'));
                return Response::json('success', 200);
                break;
        }
    }

    private function sendEmail($name, $contact, $template, $from){
        Mail::send(['html' => $template], [
                'name' => $name,
                'contact' => $contact,
                'from' => $from
            ], function ($message) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Housestars');
                $message->subject('Suggestion');
            });
    }
}
