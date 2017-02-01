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
use Response;

class TradesmanController extends Controller
{

    public function dashboard(){

    	$meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
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


    	return View::make('dashboard/tradesman/profile')->with('data', $data);
    }

    public function edit()
    {
    	$suburbs = Suburbs::all();
    	$meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
    	$data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $x = 0; $y = 0;

    	foreach ($meta as $key) {
    		if($key->meta_name == 'positions'){
    			$positions = explode(",", $key->meta_value);
    			
    			foreach ($positions as $position) {
    				$code[$x] = substr($position, 0, 4);
    				$suburb[$x] = substr($position, 4);
    				$data['suburbs'][$x] = array('code' => $code[$x], 'name' => $suburb[$x]);
  					$x = $x + 1;
    			}


    		} else if($key->meta_name == 'gallery'){
    			$data[$key->meta_name][$y] = array('id'=>$key->id, 'url'=> $key->meta_value);
    			$y = $y + 1;

    		} else {

    			if(strlen($key->meta_value) > 30 && $key->meta_name == 'trade'){
    				
    				$data[$key->meta_name] = substr($key->meta_value, 0, 30).'...';
    			} else {
    				$data[$key->meta_name] = $key->meta_value;
    			}
    		}
    		
    	}


    	return View::make('dashboard/tradesman/edit')->with('data', $data)->with('suburbs', $suburbs);
    }

    public function upload(Request $request){

        if ($request->hasFile('file') ) {
            $user_id = Sentinel::getUser()->id;
            $file = $request->file('file');
            $data = array();
	        $localpath = 'user/user-'.$user_id.'/uploads';
	        $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
			$path = $file->move(public_path($localpath), $filename);
			$url = $localpath.'/'.$filename;
					
			UserMeta::updateOrCreate(['user_id' => $user_id, 'meta_name' => 'gallery', 'meta_value' => $url]);
            array_push($data, $url);
	

	        return Response::json('success', 200);
        }

        return Response::json('error', 400);
    }

    public function updateProfile(Request $request)
    {
    	//dd($request->all());
    	if(Sentinel::check()){
    		$user_id = Sentinel::getUser()->id;

    		$meta_name = array('cover-photo', 'profile-photo', 'gallery', 'business-name', 'positions', 'summary', 'trade', 'website', 'abn', 'charge-rate');

    		foreach ($meta_name as $meta) {
                
                    
                if ($request->hasFile($meta) )  {
                	
                	$file = $request->file($meta);
                	$localpath = 'user/user-'.$user_id.'/uploads';
	                $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
					$path = $file->move(public_path($localpath), $filename);
					$value = $localpath.'/'.$filename;
                	
				} else {
					$value = $request->input($meta);
				}

				if($meta == 'positions' && $request->input($meta) != null && $meta != ''){
                    $suburbs = $request->input($meta);
                    $value = '';
                    
                    foreach ($suburbs as $suburb) {
                        $value .= substr($suburb, 2) . ',';
                    }
                }

				if($value !== null){
                	UserMeta::updateOrCreate(
                    	['user_id' => $user_id, 'meta_name' => $meta],
                    	['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                	);
				}
                
    		}

		    return redirect('/dashboard/tradesman/profile');
    	
    	} else {
    		return redirect('/');
    	}
    }

    public function deleteItem(Request $request){
    	if(Sentinel::check()){    		
    		DB::table('user_meta')->where('id', '=', $request->input('item-id'))->delete();
    		return redirect()->back();
    	} else {
    		return redirect('/');
    	}
    }

     public function settings()
    {

        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $data = array();
        

        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }

        \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");

        $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);

        //dd($customer_info);

        $data['credit-card'] = $customer_info->sources->data[0]->last4;
        $data['expiry-month'] = $customer_info->sources->data[0]->exp_month;
        $data['expiry-year'] = $customer_info->sources->data[0]->exp_year;
        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;
        $data['plan'] = $customer_info->subscriptions->data[0]->items->data[0]->plan->name;
        $data['subscription-status'] = $customer_info->subscriptions->data[0]->status;
        $data['subscription-expiry'] = date('F d, Y', $customer_info->subscriptions->data[0]->current_period_end);

        return View::make('dashboard/tradesman/settings')->with('data', $data);
    }

}
