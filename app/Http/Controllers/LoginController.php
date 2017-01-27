<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Response;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
    	
        $validation = $this->validate($request, [
            'email' => 'required',
            'password' => 'required|',
        ]);
        
        try{
           if( Sentinel::authenticate($request->all()))
           {
                switch (Sentinel::getUser()->roles()->first()->slug){
                    case 'agency':
                        return \Ajax::redirect('/dashboard/agency/profile');
                        break;
                    case 'tradesman':
                        return \Ajax::redirect('/dashboard/tradesman/profile');;
                        break;
                    case 'customer':
                        return \Ajax::redirect('/dashboard/customer/profile');
                        break;
                }

            }else{
                $error['message'] = array("Sorry, our system doesn't recognize your credentials");
                return Response::json($error, 422); 
           }
            

        }catch(ThrottlingException $e){
                
                $error['message'] = array('You are denied access for suspicious activity! Login again after '.$e->getDelay().' seconds');
                return Response::json($error, 422); 
                
        
        }
    	

        
    }

    public function logout(){
        Sentinel::removeCheckpoint('throttle');
    	Sentinel::logout();

    	return redirect('/');
    }


}
