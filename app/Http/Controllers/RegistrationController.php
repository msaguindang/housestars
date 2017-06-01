<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use App\Services\AbnService;
use Sentinel;
use App\User;
use App\UserMeta;
use App\Property;
use App\Agents;
use App\RoleUsers;
use App\Suburbs;
use App\Category;
use View;
use Response;
use Activation;
use Mail;

class RegistrationController extends Controller
{
    const COUPON = 'HSe1A172';

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
        $abnService = new AbnService();

    	if (Sentinel::check()) {
    		$user_id = Sentinel::getUser()->id;
    		$role = Sentinel::getUser()->roles()->first()->slug;
            
    		if ($role == 'agency') {
                $meta_name = array('agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'positions', 'base-commission', 'marketing-budget', 'sales-type', 'review-url', 'abn');
    			foreach ($meta_name as $meta) {
                    if ($request->input($meta) != null || $request->input($meta) != '') {
                        $value = $request->input($meta);

                        if($meta == 'positions' && $request->input($meta) != null) {
                            $suburbs = $request->input($meta);
                            $value = '';
                            foreach ($suburbs as $suburb) {
								
								if(strpos($suburb,",") !== FALSE){
	                            	$suburb = explode(",", $suburb)[1];
	                            	if(strpos($suburb,"-dup") !== FALSE){
	                                    $suburb = explode("-dup", $suburb)[0];
	                                }
	                            } else if(strpos($suburb,"-dup") !== FALSE) {
                                    $suburb = explode("-dup", $suburb)[0];
                                }
                                $value .= $suburb. ',';
                            }
                        } else if ($meta == 'abn') {
                            if (UserMeta::where('user_id', '!=', $user_id)->where('meta_name', $meta)->where('meta_value', $request->get($meta))->exists()) {
                                return redirect()->back()->withError("ABN already exist!");
                            }
                            $abnResponse = $abnService->searchByAbn($request->get($meta));
                            $abnResult = $abnResponse->ABRPayloadSearchResults->response;
                            if (isset($abnResult->exception)) {
                                return redirect()->back()->withError("Invalid ABN");
                            }
                        }

                        UserMeta::updateOrCreate(
                            ['user_id' => $user_id, 'meta_name' => $meta],
                            ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                        );
                    }
    			}
    			
    			$this->updateAvailability();
    			
    			if(Sentinel::getUser()->subs_status == 0){
	    			return redirect(env('APP_URL').'/register/agency/step-three');
    			}

		      	return redirect(env('APP_URL').'/register/agency/step-two');

    		} else if (strtolower($role) == 'tradesman') {
                $meta_name = array('business-name', 'positions', 'trading-name', 'summary', 'promotion-code', 'trade', 'website', 'charge-rate', 'phone-number', 'abn');
                foreach ($meta_name as $meta) {
                    if ($request->input($meta) != null || $request->input($meta) != '') {
                        $value = $request->input($meta);
                        if($meta == 'positions' && $request->input($meta) != null) {
                            $suburbs = $request->input($meta);
                            $value = '';
                            foreach ($suburbs as $suburb) {
                                $value .= $suburb . ',';
                            }
                        } else if(($meta == 'trade') && ($trades = $request->get('trade', []))) {
                            foreach ($trades as $tradeId) {
                                UserMeta::updateOrCreate(
                                    ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $tradeId],
                                    ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $tradeId]
                                );
                            }
                            continue;
                        }
/*
                        else if ($meta == 'abn') {
                            if (UserMeta::where('user_id', '!=', $user_id)->where('meta_name', $meta)->where('meta_value', $request->get($meta))->exists()) {
                                return redirect()->back()->withError("ABN already exist!");
                            }
                            $abnResponse = $abnService->searchByAbn($request->get($meta));
                            $abnResult = $abnResponse->ABRPayloadSearchResults->response;
                            if (isset($abnResult->exception)) {
                                return redirect()->back()->withError("Invalid ABN");
                            }
                        }
*/
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
        $property_meta = array('property-type','number-rooms','post-code', 'property-address', 'suburb','state','leased','value-from','value-to','more-details','agent', 'commission');
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
			$propertyInfo = Property::where('property_code', $property_code)->get();
            if($meta == 'agent' && $request->input($meta) != null && $request->input($meta) != 0 && $request->input($meta) != 1){
              
              $agencyEmail =  User::where('id', $request->input($meta))->first()->email;

              foreach ($propertyInfo as $info) {
                $data[$info->meta_name] = $info->meta_value;
              }
              $data['code'] = $request->input('code');
              $this->notifyAgency($data, $agencyEmail);
            }
            
            //Get property info for email
            
             foreach ($propertyInfo as $info) {
                $property[$info->meta_name] = $info->meta_value;
             }
             $property['code'] = $request->input('code');
 
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
        

        $property['customer_name'] = Sentinel::getUser()->name;
        $property['customer_email'] = Sentinel::getUser()->email;
        
        $adminEmail = 'info@housestars.com.au';
        $this->notifyAdmin($property, $adminEmail);
		$this->notifyCustomer($property, Sentinel::getUser()->email);
		
        return redirect(env('APP_URL').'/register/customer/complete');

    }

    public function postAddAgents(Request $request)
    {
        if (Sentinel::check()) {

            $user_id = Sentinel::getUser()->id;
            $role = Sentinel::getUser()->roles()->first()->slug;
            $agents = $request->input('add-agents');

            if ($agents != null) {
				
                foreach ($agents as $agent) {
                    try{

                        if($agent['name'] != '' && $agent['email'] != '' && $agent['password'] != ''){
							
                            $credentials =  [
                                'email'    => $agent['email'],
                                'password'    => $agent['password'],
                            ];
							
                            $user = Sentinel::registerAndActivate($credentials);
                            User::where('email', $user->email)->update(['name' => $agent['name']]);
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
        $data = [];
        if ($user = Sentinel::getUser()) {
	        $userMetas = UserMeta::where('user_id', $user->id)->get();
	        foreach ($userMetas as $userMeta) {
                if (strtolower($userMeta->meta_name) == 'positions') {
                    $positions = explode(',', $userMeta->meta_value);
                    foreach ($positions as $key => $pos) {
                        preg_match_all('!\d!', $pos, $matches);
                        if (isset($matches[0]) && !empty($pos)) {
                            $data[$userMeta->meta_name][$key]['id'] = implode('', $matches[0]);
                            $data[$userMeta->meta_name][$key]['name'] = trim(str_replace($data[$userMeta->meta_name][$key]['id'], '', $pos));
                            $data[$userMeta->meta_name][$key]['availability'] = Suburbs::where('id', $data[$userMeta->meta_name][$key]['id'])->where('name', $data[$userMeta->meta_name][$key]['name'])->first()->availability;
                        }
                    }
                } else {
                    $data[$userMeta->meta_name] = $userMeta->meta_value;
                }
            }
        }
        
        $positions = isset($data['positions']) ? $data['positions'] : [];
        $data['pos_json'] = json_encode($positions);
        $data['sub_status'] = Sentinel::getUser()->subs_status;
        $this->updateAvailability();
        return View::make('register/agency/step-one')->with('suburbs', $suburbs)->with('user', $data);
    }

    public function Tradesman()
    {
        $suburbs = Suburbs::all();
        $data = [];

        if ($user = Sentinel::getUser()) {
            $userMetas = UserMeta::where('user_id', $user->id)->get();
            foreach ($userMetas as $userMeta) {
                if (strtolower($userMeta->meta_name) == 'positions') {
                    $positions = explode(',', $userMeta->meta_value);
                    foreach ($positions as $key => $pos) {
                        preg_match_all('!\d!', $pos, $matches);
                        if (isset($matches[0]) && !empty($pos)) {
                            $data[$userMeta->meta_name][$key]['id'] = implode('', $matches[0]);
                            $data[$userMeta->meta_name][$key]['name'] = trim(str_replace($data[$userMeta->meta_name][$key]['id'], '', $pos));
                        }
                    }
                } else {
                    $data[$userMeta->meta_name] = $userMeta->meta_value;
                }
            }
        }
        return View::make('register/tradesman/step-one')->with(['suburbs' => $suburbs, 'categories' => Category::whereStatus(1)->orderBy('category', 'ASC')->groupBy('category')->get(), 'data' => $data]);
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

        if ($role == 'agency') {
            return View::make('register/agency/step-three')->with('suburbs', $suburbs);
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

        if ($role != 'customer') {                
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

        if(strtolower($role) == 'tradesman') {
            $trades = UserMeta::where('user_id', $user_id)
                                ->join('categories', 'categories.id', '=', 'user_meta.meta_value')
                                ->where('user_meta.meta_name', 'trade')
                                ->get(['categories.category'])->toArray();

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
            $data['plan'] = $customer_info->metadata->selected;

            if($data['plan'] == 'yearly') {
                $price =  550;
                $expiry = date('F d, Y', strtotime('+1 year'));
            } else {
                $price =  50;
                $expiry = date('F d, Y', strtotime('+1 month'));
            }
            $data = [
                'userinfo'  => $userinfo,
                'email'     => $user_email,
                'positions' => $positions,
                'expiry'    => $expiry,
                'price'     => $price,
                'trades'    => array_remove_null(array_flatten($trades))
            ];
            return View::make('register/tradesman/step-three')->with($data);
        } else if($role == 'agency') {
			if(count($positions) > 1) {
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
            $coupon = $request->get('coupon', null);

                try{
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
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
                    
                    $userData = [
                        'description' => $description,
                        'email' => $user_email,
                        'source' => $token,
                        'metadata' =>  $subscription
                    ];

                    $customer = \Stripe\Customer::create($userData);
                    if ($coupon && ($coupon == Sentinel::getUser()->coupon)) {
                        throw new \Exception("You can't use same coupon twice!");
                    }else if ($coupon && $coupon != self::COUPON) {
                        throw new \Exception("Invalid coupon code!");
                    }

                    User::where('id', $user_id)->update(['customer_id' => $customer->id, 'coupon' => $coupon]);
                } catch (\Stripe\Error\Card $e) {

                    $body = $e->getJsonBody();
                    $err  = ''.$body['error']['message'].'';

                    return redirect()->back()->with('error', $err);
                } catch(\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
			
			if(Sentinel::getUser()->subs_status == 0){
				User::where('id', $user_id)->update(['subs_status' => 1]);
			}
			
            if(strtolower($role) == 'tradesman') {
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
            $coupon = Sentinel::getUser()->coupon;

            try {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
       
                $data = [
                    "customer" => Sentinel::getUser()->customer_id,
                    "plan" => $request->input('plan')
                ];
                
                if (!is_null($coupon) && !empty($coupon)) {
                    $data['coupon'] = $coupon;
                }

                \Stripe\Subscription::create($data);

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
    
    private function notifyCustomer($property, $email){
        // $property_name = $property->suburb. ', '.$property->state;
        Mail::send(['html' => 'emails.customer-welcome'], [
                'property' => $property
            ], function ($message) use ($email) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to($email);
                $message->subject('Welcome to Housestars');
            });
    }
    
     private function notifyAdmin($property, $email){
        // $property_name = $property->suburb. ', '.$property->state;
        Mail::send(['html' => 'emails.admin-property'], [
                'property' => $property
            ], function ($message) use ($property) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au');
                $message->subject('New Customer Sign-up: '. $property['customer_name']);
            });
    }
    
    public function updateAvailability()
    {
		DB::table('suburbs')->update(['availability' => 0]);

    	$suburbs = UserMeta::where('meta_name', 'positions')->get();
	    $positions = [];
	    	
	    foreach($suburbs as $suburb){
		    if(!is_null(RoleUsers::hasRole($suburb->user_id, 2)->first())) {
	           $subs = explode(",", $suburb->meta_value);
	            foreach($subs as $sub){
		           array_push($positions, $sub);
	            }
	        }
	    }
	    $availabilityCount = array_count_values($positions);
	    	
	    foreach($availabilityCount as $suburb => $count){
		    $postcode = preg_replace('/\D/', '', $suburb);
		    $suburb_name = preg_replace('/\d/', '', $suburb);
		    	
		    if($count > 3){
			    $count = 3;
		    }
		    Suburbs::where('id', $postcode)->where('name', $suburb_name)->update(['availability' => $count]);
	    }
	}
	    	

}
