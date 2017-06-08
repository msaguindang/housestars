<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use App\User;
use URL;
use App\UserMeta;
use DateTime;

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
				$date1 = new DateTime;
				
				if ($metaPos = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name', 'positions')->first()) {
					
					$date = $metaPos->updated_at;
					$date2 = new DateTime($date);
					$interval = $date2->diff($date1);

					if((int)$interval->format("%H") >= 2 && Sentinel::getUser()->subs_status == NULL){
						
						UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name', 'positions')->update(['meta_value' => '']);
						
					}
				}
				
				$meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
				$positions = '';
				if ($pos = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name','positions')->first()) {
					$positions = $pos->meta_value;
				}
	            $isPaidCustomer = count(explode(",", $positions));
                
                if(count($meta) < 2){
	                
                  return redirect('/register/agency/step-one');
                  
                }else if($positions == ''){
	                
	                return redirect('/register/agency/step-one');

                }else if (Sentinel::getUser()->customer_id == NULL) {

	                return redirect('/register/agency/step-three');   
	                     
	            } else if(Sentinel::getUser()->customer_id != NULL && Sentinel::getUser()->subs_status == NULL && strtolower($request->route()->uri) != "register/agency/step-four"){
		            
		            return redirect('/register/agency/step-four');
		            
	            }else if($isPaidCustomer > '2' || $isPaidCustomer == 1 ) {
					if(Sentinel::getUser()->customer_id) {
	                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
	                  $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
	                  $payment_status = $customer_info->status;
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
