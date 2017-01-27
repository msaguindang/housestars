<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use View;
use Sentinel;
use App\User;
use App\UserMeta;
use App\Suburbs;
use Carbon\Carbon;
use Hash;
use App\Agents;

class AgencyController extends Controller
{
    public function dashboard(){
    	$meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $dp = 'assets/default.png';
        $cp = 'assets/default_cover_photo.jpg';
    	foreach ($meta as $data) {
    		if($data->meta_name == 'profile-photo'){
    			$dp = $data->meta_value;
    		} else if($data->meta_name == 'cover-photo'){
    			$cp = $data->meta_value;
    		}
    	}

        return View::make('dashboard/agency/profile')->with('meta', $meta)->with('dp', $dp)->with('cp', $cp);
    }

    public function edit()
    {

    	$meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
    	$data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';

    	foreach ($meta as $key) {
    		$data[$key->meta_name] = $key->meta_value;
    	}


    	return View::make('dashboard/agency/edit')->with('data', $data);
    }

    public function updateProfile(Request $request)
    {

    	//dd($request->all());
    	if(Sentinel::check()){
    		$user_id = Sentinel::getUser()->id;

    		$meta_name = array('cover-photo', 'profile-photo', 'agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'base-commission', 'marketing-budget', 'sales-type', 'summary');

    		foreach ($meta_name as $meta) {
                
                    
                if ($request->hasFile($meta)) {
                	$localpath = 'user/user-'.$user_id.'/uploads';
                	$filename = 'img-'.Carbon::now()->format('YmdHis').'.'.$request->file($meta)->getClientOriginalExtension();
					$path = $request->file($meta)->move(public_path($localpath), $filename);
					$value = $localpath.'/'.$filename;
				} else {
					$value = $request->input($meta);
				}

				if($value !== null){
					UserMeta::updateOrCreate(
                    ['user_id' => $user_id, 'meta_name' => $meta],
                    ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                );
				}
                
    		}

		    return redirect('/dashboard/agency/profile');
    	
    	} else {
    		return redirect('/');
    	}
    }

    public function settings()
    {

        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $agents = DB::table('users')
                    ->join('agents', function ($join) {
                        $join->on('users.id', '=', 'agents.agent_id')
                             ->where('agents.agency_id', '=', Sentinel::getUser()->id);
                    })
                    ->get();
        $data = array();
        

        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }

        \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");

        $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);

        $data['credit-card'] = $customer_info->sources->data[0]->last4;
        $data['expiry-month'] = $customer_info->sources->data[0]->exp_month;
        $data['expiry-year'] = $customer_info->sources->data[0]->exp_year;
        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;

        return View::make('dashboard/agency/settings')->with('data', $data)->with('agents', $agents);
    }

    public function updateSettings(Request $request)
    {
        if(Sentinel::check())
        {
            $id = Sentinel::getUser()->id;

            if($request->input('password') == ''){
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name')]);
            } else {
                $password = Hash::make($request->input('password'));
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name'), 'password' => $password]);
            } 

            return redirect()->back();

        } else {
            return redirect('/');
        }

    }

    public function updatePayment(Request $request)
    {
        if(Sentinel::check())
        {
            $customer_id = Sentinel::getUser()->customer_id;

            \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");

            try{
                $token = \Stripe\Token::create(
                        array(
                            'card'=> array(
                            'number' => $request->input('credit-card'),
                            'exp_month' => $request->input('exp_month'),
                            'exp_year' => $request->input('exp_year'),
                            'cvc' => $request->input('cvc')
                                )
                            )
                        );
                $customer = \Stripe\Customer::retrieve($customer_id);
                $customer->source = $token; // obtained with Stripe.js
                $customer->save();
                return redirect()->back();
            }catch (\Stripe\Error\Card $e){

                $body = $e->getJsonBody();
                $err  = ''.$body['error']['message'].'';
                    
                return redirect()->back()->with('error', $err);

            }
            

        } else {
            return redirect('/');
        }

    }

    public function deleteAgent(Request $request)
    {
         if(Sentinel::check()){
            $id = $request->input('agent-id');
            User::where('id', '=', $id )->delete();
            Agents::where('agent_id', '=', $id )->delete();
             return redirect()->back();
         } else {
            return redirect('/');
         }
    }

    public function updateAgent(Request $request)
    {
        if(Sentinel::check()){

          $agents = $request->input('add-agents');
            foreach ($agents as $agent) {
                if($agent['name'] != '' && $agent['email'] != ''){
                    if(isset($agent['id'])){
                        
                        if($agent['password'] == ''){
                            User::updateOrCreate(
                                ['id' => $agent['id']],
                                ['id' => $agent['id'], 'email' => $agent['email'], 'name' => $agent['name']]);
                        } else {
                            $password = Hash::make($agent['password']);
                            User::updateOrCreate(
                                ['id' => $agent['id']],
                                ['id' => $agent['id'], 'email' => $agent['email'], 'name' => $agent['name'], 'password' => $password]);
                        } 

                        if(isset($agent['active'])){
                            Agents::updateOrCreate(
                                ['agent_id' => $agent['id']],
                                ['agent_id' => $agent['id'], 'active' => 1]);
                        } else {
                            Agents::updateOrCreate(
                                ['agent_id' => $agent['id']],
                                ['agent_id' => $agent['id'], 'active' => 0]);
                        }
                    } else {
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
                            
                        $user_id = Sentinel::getUser()->id;
                        $agent_id = Sentinel::findByCredentials($email);

                        if(isset($agent['active'])){
                                Agents::firstOrCreate(['agent_id' => $agent_id['id'], 'agency_id' => $user_id, 'active' => 1]);
                        } else {
                                Agents::firstOrCreate(['agent_id' => $agent_id['id'], 'agency_id' => $user_id]);
                        }
                    }
                }
            } 

          return redirect()->back();

        } else {
            return redirect('/');
        }
    }



}
