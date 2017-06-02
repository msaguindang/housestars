<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use URL;
use App\UserMeta;
use App\User;

class TradesmanMiddleware
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
                case 'tradesman':
                  $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();

                  if(count($meta) < 2){
                    return redirect('/register/tradesman/step-one');
                  }

                  if(Sentinel::getUser()->customer_id){
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                    $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
                    $payment_status = $customer_info->status;

                    if($payment_status ==  'past_due' || $payment_status ==  'canceled' || $payment_status ==  'unpaid' || Sentinel::getUser()->subs_status == 0){
		    			        User::where('id', Sentinel::getUser()->id)->update(['subs_status' => 0]);
                      return redirect('/register/tradesman/step-two');
                    } else if (count($customer_info->subscriptions->data) == 0 && strtolower($request->route()->uri) != "register/tradesman/step-three") {
                      return redirect('/register/tradesman/step-three');
                    }
                  } else {
                    return redirect('/register/tradesman/step-two');
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
