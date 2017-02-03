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
use View;
use Response;

class RegistrationController extends Controller
{   

    public function postRegister(Request $request)
    {

    	$validation = $this->validate($request, [
            'name' => 'required|max:30',
	        'email' => 'required|unique:users|max:30',
	        'password' => 'required|min:6|confirmed',
	        'password_confirmation' => 'required|min:6'
	    ]);

            $user = Sentinel::registerAndActivate($request->all());

            Sentinel::login($user);

            $account = $request->input('account');
                
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

    public function postUserMeta(Request $request)
    {
    	if(Sentinel::check()){
    		$user_id = Sentinel::getUser()->id;
    		$role = Sentinel::getUser()->roles()->first()->slug;

    		
    	   

    		if($role == 'agency'){
                $meta_name = array('agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'positions', 'base-commission', 'marketing-budget', 'sales-type');

    			foreach ($meta_name as $meta) {

                    if($request->input($meta) != null || $request->input($meta) != '')
                    {
                        $value = $request->input($meta);

                        if($meta == 'positions' && $request->input($meta) != null){
                            $suburbs = $request->input($meta);
                            $value = '';
                            foreach ($suburbs as $suburb) {
                                $value .= substr($suburb, 2) . ',';

                                // Update suburb availability
                                $suburb = Suburbs::find(substr($suburb, 2));
                                $available = $suburb->availability +  1;
                                $suburb->availability = $available;
                                $suburb->save();

                            }
                        }

                        UserMeta::updateOrCreate(
                            ['user_id' => $user_id, 'meta_name' => $meta],
                            ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                        );
                    }
    			}

		      	return redirect('/register/agency/step-two');
    		} else if($role == 'tradesman'){
                $meta_name = array('business-name', 'positions', 'trading-name', 'summary', 'promotion-code', 'trade', 'website', 'abn', 'charge-rate');
                foreach ($meta_name as $meta) {
                    if($request->input($meta) != null || $request->input($meta) != '')
                    {
                        $value = $request->input($meta);

                        if($meta == 'positions' && $request->input($meta) != null){
                            $suburbs = $request->input($meta);
                            $value = '';
                            foreach ($suburbs as $suburb) {
                                $value .= substr($suburb, 2) . ',';

                            }
                        }

                        UserMeta::updateOrCreate(
                            ['user_id' => $user_id, 'meta_name' => $meta],
                            ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                        );
                    }
                }

                return redirect('/register/tradesman/step-two');
                
            }
    	
    	} else {
    		return redirect('/');
    	}

    } 

    public function addProperty(Request $request)
    {   
        $user_id = Sentinel::getUser()->id;
        $property_meta = array('property-type','number-rooms','post-code','suburb','state','leased','value-from','value-to','more-details','agent');
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

        return redirect('/register/customer/complete');

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

                            
                            
                            //return redirect('/register/agency/step-three');
                        } else {
                            return redirect('/register/agency/step-three');
                        }
                        
                    }
                    catch (\Exception $e){
                        $error = $agent['email'].' already in use, please use another email address.';
                        return redirect()->back()->with('error', $error);
                    }
                    
                }

                return redirect('/register/agency/step-three');

            } else {
                return redirect('/register/agency/step-three');
            }

        } else {
            return redirect('/');
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
        return View::make('register/tradesman/step-one')->with('suburbs', $suburbs);
    
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
        $agencies = DB::table('users')
                        ->join('role_users', function ($join) {
                            $join->on('users.id', '=', 'role_users.user_id')
                                 ->where('role_users.role_id', '=', 2);
                        })
                        ->get();

         $suburbs = DB::table('user_meta')->where('meta_value', 'LIKE', '%'.$request->input('suburb').'%')->get();

        $data = array();

        foreach ($agencies as $agency) {
           foreach ($suburbs as $suburb) {
                if($suburb->user_id == $agency->id){
                    array_push($data, $agency);
                }
           }
        }
        
        if(empty($data )){
            return Response::json('error', 422); 
        } else {
            return Response::json($data , 200); 
        }
    }

    public function payment()
    {
            $suburbs = Suburbs::all();
            $role = Sentinel::getUser()->roles()->first()->slug;

            if($role == 'agency'){
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

        if($role != 'customer'){
            foreach ($userinfo as $info) {
               if($info->meta_name == 'positions'){
                    $pos = explode(",", $info->meta_value);
               }
            }
             foreach ($pos as $position) {
                if(!empty($position)){
                    array_push($positions, substr($position, 4));
                }
             }

             $price =  count($positions) * 2000;

             if($price == 6000){
                $price =  5000;
             }
        }       

        if($role == 'tradesman'){
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

             $price =  count($positions) * 2000;
             if($price == 6000){
                $price =  5000;
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
                    if($role == 'Tradesman'){
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
                    
                    //dd($err);
                    return redirect()->back()->with('error', $err);
                }
            
            if($role == 'Tradesman'){
                return redirect('/register/tradesman/step-three');
            } else {
                return redirect('/register/agency/step-four');
            }
            

        } else {
            return redirect('/');
        }

       
    }

    public function postCharge(Request $request)
    {
        if(Sentinel::check()){

            try {
            $role = Sentinel::getUser()->roles()->first()->name;

            \Stripe\Stripe::setApiKey('sk_test_qaq6Jp8wUtydPSmIeyJpFKI1');

            \Stripe\Subscription::create(array(
              "customer" => Sentinel::getUser()->customer_id,
              "plan" => $request->input('plan')
            ));

            $request->session()->put('completed', 'yes');

            if($role == 'Tradesman'){
                return redirect('/register/tradesman/complete');
            } else {
                return redirect('/register/agency/complete');
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
}
