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
