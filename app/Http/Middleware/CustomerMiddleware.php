<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use URL;
use App\UserMeta;

class CustomerMiddleware
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
                case 'customer':
                    $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();

                    if (count($meta) < 2) {
                      return redirect('/register/customer/step-one');
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
