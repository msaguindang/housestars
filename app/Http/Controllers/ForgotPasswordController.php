<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Reminder;
use Mail;
use Sentinel;
use Response;

class ForgotPasswordController extends Controller
{
    public function retrieve(Request $request){

        if($request->input('email') == ''){
             $data['err'] = 'Please add an email address.';
            return Response::json($data, 200);
        }

    	$user = User::whereEmail($request->input('email'))->first();

        //dump($user);
    	$sentinelUser = Sentinel::findById($user['id']);

    	if(count($user) == 0){
            $data['err'] = 'Email address doesn\'t match our record. Please try again.';
            return Response::json($data, 200);
    	} 

    	$reminder = Reminder::exists($sentinelUser) ?: Reminder::create($sentinelUser);
    	$this->sendEmail($sentinelUser, $reminder->code);

        $data['msg'] = 'Reset code has been sent, please check your email.';

        return Response::json($data, 200);
    }

    public function resetPassword($email, $code){

        $user = User::whereEmail($email)->first();
        $sentinelUser = Sentinel::findById($user['id']);

        if(count($user) == 0){
            abort(404);
        } 

        if($reminder = Reminder::exists($sentinelUser)){
            if($code == $reminder->code)
                return view('general.reset-password');
            else
                return redirect(env('APP_URL'));
        } else {
            return redirect(env('APP_URL'));
        }

    }

    public function reset(Request $request, $email, $code){

        $this->validate($request, [
                'password' => 'confirmed|required|min:6',
                'password_confirmation' =>'required|min:6'
            ]);
        $user = User::whereEmail($email)->first();
        $sentinelUser = Sentinel::findById($user['id']);

        if(count($user) == 0){
            abort(404);
        } 

        if($reminder = Reminder::exists($sentinelUser)){
            if($code == $reminder->code){
                Reminder::complete($sentinelUser, $code, $request->password);
                return redirect('reset-success');
            } else {
                return redirect(env('APP_URL')); 
            }
                
        } else {
            return redirect(env('APP_URL'));
        }
    }

    private function sendEmail($user, $code){
    	Mail::send(['html' => 'emails.forgot-password'], [
    			'user' => $user,
    			'code' => $code
    		], function ($message) use ($user) {
                $message->from('info@housestars.com.au', 'Housestars');
    			$message->to($user->email);
    			$message->subject('Password Reset');
    		});
    }
}
