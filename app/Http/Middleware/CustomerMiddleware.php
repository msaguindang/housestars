<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

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
