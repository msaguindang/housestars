<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Suburbs;
use App\UserMeta;
use App\User;
use App\Role;
use Response;

class SearchController extends Controller
{
    public function search(Request $request, $item){

    	switch ($item) {
    		case 'category':
    			$data = $this->category($request->input('suburb'));
    			return Response::json($data, 200);
    			break;
    		
    		default:
    			$data['error'] = 'Please enter a suburb';
    			return Response::json($data, 200);
    			break;
    	}

    }

    public function category($suburb){

    	$suburbExists = UserMeta::where('meta_value', 'LIKE', '%'.$suburb.'%')->get();

    	if(count($suburbExists) == 0){
    		$data['msg'] = 'No result found for '. $suburb;
    		return $data;
    	}

    	$tradesmen = array();

    	foreach ($suburbExists as $key) {
            $activeUser = User::where('id', '=', $key->user_id)->get();
            if(count($activeUser) > 0){
        		$roles =  Role::where('user_id', $key->user_id)->where('role_id', 3)->get();

        		foreach($roles as $role){
        			//echo $role->user_id. ' = '. $role->role_id.', ';
        			if($role->role_id == 3){
        				$tradesman = UserMeta::where('meta_name', 'trade')->where('user_id', $key->user_id)->get();
    	    			array_push($tradesmen, $tradesman);
    	    		}
        		}
            }
    	}

    	$data = array();

    	//dd($tradesmen);

    	if(count($tradesmen) == 0){
    		$data['msg'] = 'No result found for '. $suburb;
    		return $data;
    	}

    	foreach ($tradesmen as $tradesman) {
    		if(!in_array($tradesman[0]->meta_value, $data)){
    			array_push($data, $tradesman[0]->meta_value);
    		}
    	}

    	//if tradesman return catagory

    	return $data;
    }

    public function listing($category){

        $trade = UserMeta::where('meta_value', 'LIKE', '%'.$category.'%')->get();

        $tradesmen = array();

        foreach ($trade as $key) {
            array_push($tradesmen, $key->user_id);
        }

        //$data = array();

        foreach ($tradesmen as $id) {
           $activeUser = User::where('id', '=', $id)->get();
           if(count($activeUser) > 0){
                $tradesmanData = UserMeta::where('user_id', '=', $id)->get();
                foreach ($tradesmanData as $value) {
                   $data[$value->user_id][$value->meta_name] = $value->meta_value;
                }
                $data[$value->user_id]['rating'] = $this->getRating($id);
                $data[$value->user_id]['id'] = $value->user_id;
           }
        }

        $data['cat'] = $category;

        //  dd($data);

       return view('general.tradesman-listings')->with('data', $data);
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
}
