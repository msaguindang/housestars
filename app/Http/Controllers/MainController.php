<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class MainController extends Controller
{
    function dashboard(){
    	if(Sentinel::check()){

            switch (Sentinel::getUser()->roles()->first()->slug){
                case 'agency':
                    return redirect('/dashboard/agency/profile');
                    break;
                case 'tradesman':
                    return redirect('/dashboard/tradesman/profile');
                    break;
                case 'customer':
                    return redirect('/dashboard/customer/profile');
                    break;
                default: 
                    return redirect(URL::previous());
                    break;
            }

        } else { 
            return redirect('/');
        }
    }
}
