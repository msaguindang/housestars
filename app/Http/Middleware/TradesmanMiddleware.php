<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use URL;

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

                  if(count($meta) == 0){
                    return redirect('/register/tradesman/step-one');
                  }

                  if(Sentinel::getUser()->customer_id){
                    \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");
                    $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
                  //  $payment_status = $customer_info->subscriptions->data[0]->status;

                    dd($customer_info);
                    if($payment_status ==  'past_due' || $payment_status ==  'canceled' || $payment_status ==  'unpaid'){
                      return redirect('/payment-status');
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
