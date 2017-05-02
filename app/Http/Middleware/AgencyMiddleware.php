<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
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
				
				$positions = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name','positions')->first()->meta_value;
	            $isPaidCustomer = count(explode(",", $positions));
	            
	            if($isPaidCustomer > '2'){
					if(Sentinel::getUser()->customer_id) {
	                  \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");
	                  $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
	                  $payment_status = $customer_info->status;
	
	
	                  if($payment_status ==  'past_due' || $payment_status ==  'canceled' || $payment_status ==  'unpaid'){
	                    return redirect('/payment-status');
	                  }
	                } else {
	                  return redirect('/register/agency/step-three');
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
