<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Sentinel;
use Activation;

class ActivationController extends Controller
{
    public function activate($email, $code, $account){
    	
    	$user = User::whereEmail($email)->first();

    	$sentinelUser = Sentinel::findById($user->id);
    	Sentinel::login($sentinelUser);

    	if(Activation::complete($sentinelUser, $code)){

    		 switch ($account){
                case 'agency':
                return redirect('/register/agency/step-one');
                break;
                case 'tradesman':
                return redirect('/register/tradesman/step-one');
                break;
                case 'customer':
                return redirect('/register/customer/step-one');
                break;
            }
    		
    	} else {
    		return redirect('/');
    	}
    }
}
