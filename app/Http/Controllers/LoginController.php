<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Response;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Socialite;
use App\User;
use App\UserMeta;

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
                        return \Ajax::redirect('dashboard/agency/profile');
                        break;
                    case 'tradesman':
                        return \Ajax::redirect('dashboard/tradesman/profile');;
                        break;
                    case 'customer':
                        return \Ajax::redirect('dashboard/customer/profile');
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

    public function redirectToProvider($provider){
        return Socialite::driver($provider)->redirect();
    } 

    public function handleProviderCallback($provider)
    {
        $social_user = Socialite::driver($provider)->user();
        $social_id = $social_user->id;
        $userExists = User::where('social_id', $social_id)->get();

        if(count($userExists) > 0){
            $credentials = [
                'login' => $social_user->email,
            ];

            $user = Sentinel::findByCredentials($credentials);

            Sentinel::login($user);

            return redirect('/');

        } else {
            $credentials = [
                'email'    => $social_user->email,
                'password' => $social_user->token
            ];

            $user = Sentinel::registerAndActivate($credentials);

            User::where('email', $social_user->email)->update(['social_id' => $social_id, 'name' => $social_user->name]);

            UserMeta::updateOrCreate(
                    ['user_id' => $user->id, 'meta_name' => 'profile-photo'],
                    ['user_id' => $user->id, 'meta_name' => 'profile-photo', 'meta_value' => $social_user->avatar]
                );
            
            Sentinel::login($user);

            return redirect('account-type');
        } 

    }

    public function assignRole($account){

            $user = Sentinel::getUser();
            $role = Sentinel::findRoleBySlug($account);
            $role->users()->attach($user);

            switch ($account){
                case 'agency':
                return \Ajax::redirect('register/agency/step-one');
                break;
                case 'tradesman':
                return \Ajax::redirect('register/tradesman/step-one');
                break;
                case 'customer':
                return \Ajax::redirect('register/customer/step-one');
                break;
            }
    }


}
