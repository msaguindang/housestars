<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use URL;

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
                if(Sentinel::getUser()->customer_id){
                  \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");
                  $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
                  $payment_status = $customer_info->subscriptions->data[0]->status;

                  if($payment_status ==  'past_due' || $payment_status ==  'canceled' || $payment_status ==  'unpaid'){
                    return redirect('/payment-status');
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
