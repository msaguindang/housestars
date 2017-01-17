<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use App\UserMeta;

class RegistrationController extends Controller
{
    public function postRegister(Request $request)
    {
    	$this->validate($request, [
	        'email' => 'required|unique:users|max:30',
	        'password' => 'required|min:6|confirmed',
	        'password_confirmation' => 'required|min:6'
	    ]);
    	
    	$user = Sentinel::registerAndActivate($request->all());

    	Sentinel::login($user);

	    $account = $request->input('account');
	    	
	    $role = Sentinel::findRoleBySlug($account);
	    $role->users()->attach($user);

	    	
	    if($account == 'agency')
	    {
	    	return redirect('/register/agency/step-one');

	    } else if($account == 'tradesman'){
	    	
	    	return redirect('/register/tradesman/step-one');

	    } else if($account == 'customer'){
	    	return redirect('/register/customer/step-one');
	    }

	    return redirect('/?error=503');

    }

    public function postUserMeta(Request $request)
    {
    	if(Sentinel::check()){
    		$user_id = Sentinel::getUser()->id;
    		$role = Sentinel::getUser()->roles()->first()->slug;

    		$meta_name = array('agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'position', 'base-commission', 'marketing-budget', 'sales-type');
    	

    		if($role == 'agency'){

    			foreach ($meta_name as $meta) {
    				UserMeta::updateOrCreate(
    					['user_id' => $user_id, 'meta_name' => $meta],
    					['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $request->input($meta)]
    				);
    			}

				return redirect('/register/agency/step-two');
    		}
    	
    	} else {
    		return redirect('/');
    	}

    } 
}
