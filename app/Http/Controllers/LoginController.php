<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Response;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
    	
        $validation = $this->validate($request, [
            'email' => 'required',
            'password' => 'required|',
        ]);
        
        try{
            Sentinel::authenticate($request->all());
            if(Sentinel::check()){
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
            }

        }catch(\Exception $e){
                
                $error['message'] = array("Your credentials don't match, please try!");
                            
                return Response::json($error, 422); 
        
        }
    	

        
    }

    public function logout(){
    	Sentinel::logout();

    	return redirect('/');
    }


}
