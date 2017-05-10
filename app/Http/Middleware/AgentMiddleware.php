<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use URL;

class AgentMiddleware
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
                case 'agent':
                    if(Sentinel::getUser()->customer_id){
                      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                      $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
                    //  $payment_status = $customer_info->subscriptions->data[0]->status;

                      dd($customer_info);
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
