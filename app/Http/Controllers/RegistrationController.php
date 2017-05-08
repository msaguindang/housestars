<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;
use App\User;
use App\UserMeta;
use App\Property;
use App\Agents;
use App\Suburbs;
use App\Category;
use View;
use Response;
use Activation;
use Mail;

class RegistrationController extends Controller
{

    public function postRegister(Request $request)
    {

    	$validation = $this->validate($request, [
            'name' => 'required|max:30',
	        'email' => 'required|unique:users',
	        'password' => 'required|min:6|confirmed',
	        'password_confirmation' => 'required|min:6'
	    ]);

        $user = Sentinel::register($request->all());

        User::where('email', $user->email)->update(['name' => $request->input('name')]);

        $activation = Activation::create($user);


        $account = $request->input('account');

        $role = Sentinel::findRoleBySlug($account);
        $role->users()->attach($user);

        $this->sendEmail($user, $activation->code, $request->input('name'), $account, $role);

        return \Ajax::redirect(env('APP_URL').'/activation-sent');
    }

    public function postUserMeta(Request $request)
    {
    	if(Sentinel::check()){
    		$user_id = Sentinel::getUser()->id;
    		$role = Sentinel::getUser()->roles()->first()->slug;


    		if($role == 'agency'){
                $meta_name = array('agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'positions', 'base-commission', 'marketing-budget', 'sales-type', 'review-url');

    			foreach ($meta_name as $meta) {

                    if($request->input($meta) != null || $request->input($meta) != '')
                    {
                        $value = $request->input($meta);

                        if($meta == 'positions' && $request->input($meta) != null){
                            $suburbs = $request->input($meta);
                            $value = '';
                            foreach ($suburbs as $suburb) {

                                if(strpos($suburb,"-dup") !== FALSE){
                                    $suburb = explode("-dup", $suburb)[0];
                                }

                                $value .= $suburb. ',';

                                // Update suburb availability
                                $sub = Suburbs::find(preg_replace('/\D/', '', $suburb));
                                DB::table('suburbs')->where('id', $sub->id)->update(['availability' => $sub->availability +  1]);

                            }
                        }

                        UserMeta::updateOrCreate(
                            ['user_id' => $user_id, 'meta_name' => $meta],
                            ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                        );
                    }
    			}

		      	return redirect(env('APP_URL').'/register/agency/step-two');

    		} else if(strtolower($role) == 'tradesman'){
                $meta_name = array('business-name', 'positions', 'trading-name', 'summary', 'promotion-code', 'trade', 'website', 'abn', 'charge-rate', 'phone-number');
                foreach ($meta_name as $meta) {
                    if($request->input($meta) != null || $request->input($meta) != '')
                    {
                        $value = $request->input($meta);

                        if($meta == 'positions' && $request->input($meta) != null){
                            $suburbs = $request->input($meta);
                            $value = '';
                            foreach ($suburbs as $suburb) {
                                $value .= $suburb . ',';

                            }
                        }

                        UserMeta::updateOrCreate(
                            ['user_id' => $user_id, 'meta_name' => $meta],
                            ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                        );
                    }
                }

                return redirect(env('APP_URL').'/register/tradesman/step-two');

            }

    	} else {
    		return redirect('/');
    	}

    }
   

    public function addProperty(Request $request)
    {
        $user_id = Sentinel::getUser()->id;
        $property_meta = array('property-type','number-rooms','post-code','suburb','state','leased','value-from','value-to','more-details','agent', 'commission');
        $user_meta = array('address', 'phone', 'username');
        $property_code = md5(uniqid(rand(), true));
        foreach ($property_meta as $meta) {
            if($request->input($meta) != null || $request->input($meta) != '')
            {
                $value = $request->input($meta);

                Property::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => $meta, 'property_code' => $property_code],
                        ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value, 'property_code' => $property_code]
                    );
            }

            if($meta == 'agent' && $request->input($meta) != null && $request->input($meta) != 0){
              $propertyInfo = Property::where('property_code', $property_code)->get();
              $agencyEmail =  User::where('id', $request->input($meta))->first()->email;

              foreach ($propertyInfo as $info) {
                $data[$info->meta_name] = $info->meta_value;
              }
              $data['code'] = $request->input('code');
              $this->notifyAgency($data, $agencyEmail);
            }
        }

        foreach ($user_meta as $meta) {
            if($request->input($meta) != null || $request->input($meta) != '')
            {
                $value = $request->input($meta);

                UserMeta::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => $meta],
                        ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                    );
            }
        }

        return redirect(env('APP_URL').'/register/customer/complete');

    }

    public function postAddAgents(Request $request)
    {
        if(Sentinel::check()){

            $user_id = Sentinel::getUser()->id;
            $role = Sentinel::getUser()->roles()->first()->slug;
            $agents = $request->input('add-agents');

            if($agents != null){

                foreach ($agents as $agent) {
                    try{

                        if($agent['name'] != '' && $agent['email'] != '' && $agent['password'] != ''){

                            $credentials =  [
                                'email'    => $agent['email'],
                                'name'    => $agent['name'],
                                'password'    => $agent['password'],
                            ];

                            $user = Sentinel::registerAndActivate($credentials);
                            $role = Sentinel::findRoleBySlug('agent');
                            $role->users()->attach($user);
                            $email = [
                                'email' => $agent['email']
                            ];
                            $agent_id = Sentinel::findByCredentials($email);

                            if(isset($agent['active'])){
                                Agents::firstOrCreate(['agent_id' => $agent_id['id'], 'agency_id' => $user_id, 'active' => 1]);
                            } else {
                                Agents::firstOrCreate(['agent_id' => $agent_id['id'], 'agency_id' => $user_id]);
                            }



                            //return redirect('register/agency/step-three');
                        } else {
                            return redirect(env('APP_URL').'/register/agency/step-three');
                        }

                    }
                    catch (\Exception $e){
                        $error = $agent['email'].' already in use, please use another email address.';
                        return redirect()->back()->with('error', $error);
                    }

                }

                return redirect(env('APP_URL').'/register/agency/step-three');

            } else {
                return redirect(env('APP_URL').'/register/agency/step-three');
            }

        } else {
            return redirect(env('APP_URL'));
        }
    }

    public function Agency()
    {

        $suburbs = Suburbs::all();
        return View::make('register/agency/step-one')->with('suburbs', $suburbs);
    }

    public function Tradesman()
    {
        $suburbs = Suburbs::all();
        return View::make('register/tradesman/step-one')->with(['suburbs' => $suburbs, 'categories' => Category::whereStatus(1)->orderBy('category', 'DESC')->get()]);
    }

    public function Customer()
    {

        $suburbs = Suburbs::all();

        $customer_info['name'] = Sentinel::getUser()->name;
        $customer_info['email'] = Sentinel::getUser()->email;
        $customer_info['password'] = Sentinel::getUser()->password;

        return View::make('register/customer/step-one')->with('suburbs', $suburbs)->with('user', $customer_info);

    }


    public function listAgency(Request $request){
      try {
          $suburb = preg_replace('/[0-9]+/', '', $request->input('data'));
          $postcode = preg_replace('/\D/', '', $request->input('data'));

          $suburbInfo =  Suburbs::where('name', $suburb)->first();
          $lat = $suburbInfo->latitude;
          $long = $suburbInfo->longitude;


          $qry = "SELECT name , id, (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - latitude) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $long - longitude) * pi()/180 / 2), 2) ))) as distance
                  from suburbs
                  having  distance <= 10
                  order by distance
                  limit 20";

            $nearby = DB::select($qry);
           // dd($nearby );
            $agencies = DB::table('users')
                            ->join('role_users', function ($join) {
                                $join->on('users.id', '=', 'role_users.user_id')
                                     ->where('role_users.role_id', '=', 2);
                            })
                            ->get();
            $search = array();
            $nearbySearch = array();
            $data['term'] = $suburb.', '.$postcode;

            $searchInArray = array_search($suburb, $nearby);
            if($searchInArray == false){
              $suburbs = DB::table('user_meta')->where('meta_value', 'LIKE', '%'.$suburb.'%')->get();
              foreach ($agencies as $agency) {
                 foreach ($suburbs as $suburb) {
                      if($suburb->user_id == $agency->id) {
                          array_push($search, json_decode(json_encode($agency), true));
                      }
                 }
              }
            }

            // dd($search);
            foreach ($nearby as $key) {
              if ($key->name != $suburb) {
                $suburbs = DB::table('user_meta')->where('meta_value', 'LIKE', '%'.$key->name.'%')->get();

                foreach ($agencies as $agency) {
                   foreach ($suburbs as $suburb) {
                        if($suburb->user_id == $agency->id) {
                            $agencyInfo['id'] = $agency->id;
                            $agencyInfo['name'] = $agency->name;
                            $agencyInfo['suburb'] = $key->name .', '.$key->id;
                            if (!in_array($agency->id, array_flatten($search))) {
                                array_push($nearbySearch, $agencyInfo);
                            }
                        }
                   }
                }
              }
            }

            $data['search'] = $search;
            $data['nearby'] = $nearbySearch;

            if(empty($data)) {
                return Response::json('error', 422);
            } else {
                return Response::json($data , 200);
            }
        } catch (\Exception $e) {
            return Response::json(['search' => [], 'nearby' => [], 'term' => ''] , 200);  
        }
    }

    public function payment()
    {
            $suburbs = Suburbs::all();
            $role = Sentinel::getUser()->roles()->first()->slug;

            if($role == 'agency'){
	            $positions = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name','positions')->first()->meta_value;
	            $isFree = count(explode(",", $positions));
	            
	            if($isFree == '2'){
		            return redirect(env('APP_URL').'/register/agency/step-four');
	            } else{
		            return View::make('register/agency/step-three')->with('suburbs', $suburbs);
	            }

            } else {
                return View::make('register/tradesman/step-two')->with('suburbs', $suburbs);
            }

    }

     public function review()
    {
        $user_id = Sentinel::getUser()->id;
        $role = Sentinel::getUser()->roles()->first()->slug;
        $user_email = Sentinel::getUser()->email;
        $userinfo = UserMeta::where('user_id', $user_id)->get();
        $positions = array();
        $expiry = date('F d, Y', strtotime('+1 year'));
		
        if($role != 'customer'){
            foreach ($userinfo as $info) {
               if($info->meta_name == 'positions') {
                    $pos = explode(",", $info->meta_value);
               }
            }
            if (isset($pos)) {
                foreach ($pos as $position) {
                    if(!empty($position)) {
                        array_push($positions, substr($position, 4));
                    }
                }
            }
             $price =  (count($positions) - 1) * 1000;

        }

        if(strtolower($role) == 'tradesman'){
            \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");
            $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
            $data['plan'] = $customer_info->metadata->selected;


            if($data['plan'] == 'yearly'){
                $price =  550;
                $expiry = date('F d, Y', strtotime('+1 year'));
             } else {
                $price =  50;
                $expiry = date('F d, Y', strtotime('+1 month'));
             }

             return View::make('register/tradesman/step-three')->with('userinfo', $userinfo)->with('email', $user_email)->with('positions', $positions)->with('expiry', $expiry)->with('price', $price);
        } else if($role == 'agency'){
			
			if(count($positions) > 1){
				$price =  (count($positions) - 1) * 1000;
			}
             
            return View::make('register/agency/step-four')->with('userinfo', $userinfo)->with('email', $user_email)->with('positions', $positions)->with('expiry', $expiry)->with('price', $price);
        } else {
            return View::make('register/customer/complete')->with('name', Sentinel::getUser()->name);
        }
    }

    public function postPayment(Request $request)
    {

        if(Sentinel::check()){

            $user_id = Sentinel::getUser()->id;
            $user_email = Sentinel::getUser()->email;
            $role = Sentinel::getUser()->roles()->first()->name;

                try{
                    \Stripe\Stripe::setApiKey('sk_test_qaq6Jp8wUtydPSmIeyJpFKI1');
                    $token = \Stripe\Token::create(
                        array(
                            'card'=> array(
                            'name' => $request->input('full-name'),
                            'number' => $request->input('number'),
                            'exp_month' => $request->input('exp_month'),
                            'exp_year' => $request->input('exp_year'),
                            'cvc' => $request->input('cvc')
                                )
                            )
                        );


                    $description = $role.' Customer';
                    $subscription = array();
                    if(strtolower($role) == 'tradesman'){
                        $subscription['selected'] = $request->input('subscription');
                    }

                    $customer = \Stripe\Customer::create(array(
                        'description' => $description,
                        'email' => $user_email,
                        'source' => $token,
                        'metadata' =>  $subscription
                    ));

                    User::where('id', $user_id)->update(['customer_id' => $customer->id]);
                } catch (\Stripe\Error\Card $e){

                    $body = $e->getJsonBody();
                    $err  = ''.$body['error']['message'].'';

                    return redirect()->back()->with('error', $err);
                }

            if(strtolower($role) == 'tradesman'){
                return redirect(env('APP_URL').'/register/tradesman/step-three');
            } else {
                return redirect(env('APP_URL').'/register/agency/step-four');
            }


        } else {
            return redirect(env('APP_URL'));
        }


    }

    public function postCharge(Request $request)
    {
        if(Sentinel::check()) {
            $role = Sentinel::getUser()->roles()->first()->name;
			$positions = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name','positions')->first()->meta_value;
	        $isFree = count(explode(",", $positions));

	        if($isFree == '2') {
                if(strtolower($role) == 'tradesman') {
                    return redirect(env('APP_URL').'/register/tradesman/complete');
                } else {
                    return redirect(env('APP_URL').'/register/agency/complete');
                }
	        } else {
	            try {
	
	            \Stripe\Stripe::setApiKey('sk_test_qaq6Jp8wUtydPSmIeyJpFKI1');
	
	            \Stripe\Subscription::create(array(
	              "customer" => Sentinel::getUser()->customer_id,
	              "plan" => $request->input('plan')
	            ));
	
	            $request->session()->put('completed', 'yes');
	
	            if(strtolower($role) == 'tradesman'){
	                return redirect(env('APP_URL').'/register/tradesman/complete');
	            } else {
	                return redirect(env('APP_URL').'/register/agency/complete');
	            }
	
	            } catch (\Stripe\Error\Card $e){
	
	                $body = $e->getJsonBody();
	                $err  = ''.$body['error']['message'].'';
	
	                return redirect()->back()->with('error', $err);
	
	            }
	        }


        } else {
            return redirect('/');
        }
    }

    private function sendEmail($user, $code, $name, $account, $role) {
        Mail::send(['html' => 'emails.activation'], [
            'user' => $user,
            'code' => $code,
            'name' => $name,
            'account' => $account
        ], function ($message) use ($user) {
            $message->from('info@housestars.com.au', 'Housestars');
            $message->to($user->email);
            $message->subject('Activate your Housestars Account');
        });

        if ($role->id == 3) { //checks if role is tradesman then send an email to admin
            Mail::send(['html' => 'emails.admin-signup-notice'], [
                'user'  => $user,
                'name'  => $name,
                'email' => $user->email,
                'link'  => route('admin.index') . '#/members'
            ], function ($message) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au');
                $message->subject('New Trade/Service Signs Up');
            });
        }
    }

    private function notifyAgency($property, $email){
        // $property_name = $property->suburb. ', '.$property->state;
        Mail::send(['html' => 'emails.property-offer'], [
                'property' => $property
            ], function ($message) use ($email) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to($email);
                $message->subject('Property Offer');
            });
    }
}
