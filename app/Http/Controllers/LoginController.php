<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Response;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Socialite;
use App\User;
use App\UserMeta;
use App\Reviews;
use Carbon\Carbon;
use DB;
use Session;
use Illuminate\View;
use Illuminate\Support\Facades\Redirect;
use App\Services\PotentialCustomerService;
use App\Services\ReviewService;
use App\PotentialCustomer;

class LoginController extends Controller
{
	public function postLogin(Request $request){

		if($request->exists('rate')) {
			return \Ajax::redirect('/choose-business');
		}

		$validation = $this->validate($request, [
			'email' => 'required',
			'password' => 'required|',
		]);

		try{
		   if( Sentinel::authenticate($request->all()))
		   {

			   $status = Sentinel::getUser()->status;

			   if(!$status) {

				   Sentinel::removeCheckpoint('throttle');
				   Sentinel::logout();

				   $error['message'] = array("Member is currently inactive");
				   return Response::json($error, 422);
			    }

				switch (Sentinel::getUser()->roles()->first()->slug){
					case 'agency':
						return \Ajax::redirect(env('APP_URL').'/dashboard/agency/profile');
						break;

					case 'tradesman':
						return \Ajax::redirect(env('APP_URL').'/dashboard/tradesman/profile');;
						break;
					case 'customer':
						return \Ajax::redirect(env('APP_URL').'/dashboard/customer/profile');
						break;
					case 'admin':
						$data['redirect'] = env('APP_URL').'/admin';
						return Response::json($data, 200);
						break;
					case 'superadmin':
						$data['redirect'] = env('APP_URL').'/admin';
						return Response::json($data, 200);
						break;
					case 'agent':
						return \Ajax::redirect(env('APP_URL').'/dashboard/agent/profile');
						break;
				}
			}
			else {
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
		session()->flush();
		return redirect('/');
	}

	public function redirectToProvider ($provider)
	{
		return Socialite::driver($provider)->redirect();
	}
	
	public function verifyToProviderToReviewBusiness ($provider, $role, $businessId)
	{
		session()->forget('email');
        session()->forget('user_type');
        session()->forget('business');
        session()->forget('role');
        
        session()->put('role', $role);
        session()->put('business', $businessId);

		return Socialite::driver($provider)
			->with(['state' => 'verify'])
			->stateless()
			->redirect();
	}

	public function verifyToProvider ($provider)
	{
		session()->forget('email');
        session()->forget('user_type');
        session()->forget('business');
        session()->forget('role');

		return Socialite::driver($provider)
			->with(['state' => 'verify'])
			->stateless()
			->redirect();
	}

	public function verifyToProviderAgency ($provider, $id)
	{
		return Socialite::driver($provider)
			->with(['state' => $id])
			->stateless()
			->redirect();
	}

	public function handleProviderCallback ($provider, Request $request)
	{
		if ($request->get('error', '') == 'access_denied' && $request->get('error_reason', '') == 'user_denied') {
			return redirect('/');
		}

		$user = Socialite::driver($provider)->stateless()->user();
		$state = $request->state;
		$stateIsNumeric = is_numeric($state);
		$email = $user->getEmail();
		$socialId = $user->getId();

		if($state == 'verify' || $stateIsNumeric) {
			$socialName = $user->getName();
			$user = User::where('email', $email)->first();
	        session()->put('email', $email);

			if(!is_null($user)) {
	            session()->put('user_type', 'user');
			} else {
				// save potential customer
				$potentialCustomer = PotentialCustomer::where('email', $email)->first();
				app(PotentialCustomerService::class)->save([
					'email'  => $email,
					'status' => 1,
					'name'   => $socialName
				], $potentialCustomer);
	            session()->put('user_type', 'potential_customer');
			}
			$secret = encrypt($socialId);

			if ($state == 'verify') {
				return redirect()->action(
					'LoginController@chooseBusiness', ['secret' => $secret]
				);
			} else {
				return redirect('/review/business/'.$state);
			}
		}
		else {
			$social_user = $user;
			$userExists = User::where('social_id', $socialId)->orWhere('email', $social_user->email)->get();

			if(count($userExists) > 0){ // if registered
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

				User::where('email', $social_user->email)->update(['social_id' => $socialId, 'name' => $social_user->name]);

				UserMeta::updateOrCreate(
						['user_id' => $user->id, 'meta_name' => 'profile-photo'],
						['user_id' => $user->id, 'meta_name' => 'profile-photo', 'meta_value' => $social_user->avatar]
					);

				Sentinel::login($user);

				return redirect('/account-type');
			}
		}
	}

	public function chooseBusiness(Request $request) {
		$params = $request->all();
		$socialId = decrypt($params['secret']);
		// $reviewer = DB::table('reviews')->where('reviewer_id', $socialId)->get();
		// if(count($reviewer) > 0) {
		// 	return redirect('/choose-business');
		// }
		return redirect('/choose-business');
	}

	public function assignRole($account){
		$user = Sentinel::getUser();
		$role = Sentinel::findRoleBySlug($account);
		$role->users()->attach($user);

		switch ($account){
			case 'agency':
			return \Ajax::redirect('/register/agency/step-one');
			break;
			case 'tradesman':
			return \Ajax::redirect('/register/tradesman/step-one');
			break;
			case 'customer':
			return \Ajax::redirect('/register/customer/step-one');
			break;
		}
	}

	public function getAgencyAndTradesman() {
		$query = DB::table('user_meta')
					->select('user_id', 'meta_name', 'meta_value')
					->where('meta_name', '=', 'agency-name')
					->orWhere('meta_name', '=', 'trading-name')
					->get();
		return json_decode($query, true);
	}

	public function deleteEmptyReview ()
    {
        $query = DB::table('reviews')->where('reviewee_id', '=', -1)->delete();
    }

}
