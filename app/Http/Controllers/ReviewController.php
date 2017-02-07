<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use View;
use Sentinel;
use App\UserMeta;
use Response;

class ReviewController extends Controller
{
    function review(Request $request){

    	//dd($request->all());
    	$user_id = Sentinel::getUser()->id;
    	$id = $request->input('id');

    	$tradesmen = DB::table('users')
				        ->join('user_meta', function ($join) use ($id) {
				            $join->on('users.id', '=', 'user_meta.user_id')
				                 ->where('user_meta.user_id', '=', $id);
				        })->get();

		$data['name'] = $tradesmen[0]->name;
		$data['photo'] = 'assets/default.png';

		foreach ($tradesmen as $tradesman) {
			if($tradesman->meta_name == 'profile-photo'){
				$data['photo'] = $tradesman->meta_value;
			}
		}

		 return Response::json($data, 200); 
    }

    function addReview(Request $request){

    	$user_id = Sentinel::getUser()->id;

    	DB::table('reviews')->insert(
            	['reviewee_id' => $request->input('tradesman_id'), 'reviewer_id' => $user_id, 'communication' => $request->input('communication'), 'work_quality' => $request->input('work-quality'), 'price' => $request->input('price'), 'punctuality' => $request->input('punctuality'), 'attitude' => $request->input('attitude'), 'title' => $request->input('review-title'), 'content' => $request->input('review-text'), 'created_at' => Carbon::now()]
            );

    	$data['id'] = $request->input('tradesman_id');
    	
    	return Response::json($data, 200); 
    }
}
