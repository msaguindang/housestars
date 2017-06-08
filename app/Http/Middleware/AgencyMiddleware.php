<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use App\User;
use URL;
use App\UserMeta;

class AgencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Sentinel::check()){

            switch (Sentinel::getUser()->roles()->first()->slug){
                case 'agency':
                $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();

                //dd($meta);

                if(count($meta) < 2){
                  return redirect('/register/agency/step-one');
                }
                
                if (Sentinel::getUser()->customer_id == NULL) {

	                return redirect('/register/agency/step-three');   
	                     
	            } else if(Sentinel::getUser()->customer_id != NULL && Sentinel::getUser()->subs_status == NULL && strtolower($request->route()->uri) != "register/agency/step-four"){
		            
		            return redirect('/register/agency/step-four');
		            
	            }
	            
	            
				
				$positions = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name','positions')->first()->meta_value;
	            $isPaidCustomer = count(explode(",", $positions));
	            
	            if($isPaidCustomer > '2' || $isPaidCustomer == 1 ) {
					if(Sentinel::getUser()->customer_id) {
	                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
	                  $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
	                  $payment_status = $customer_info->status;
	                  //dd($customer_info->subscriptions);
		                if($payment_status ==  'past_due' || $payment_status ==  'canceled' || $payment_status ==  'unpaid'){
			    		    User::where('id', Sentinel::getUser()->id)->update(['subs_status' => 0]);
			    			UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name', 'positions')->update(['meta_value' => '']);
		                    return redirect('/register/agency/step-one');
		                }
		            }
                }
                return $next($request);
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
