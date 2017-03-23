<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use URL;

class AdminMiddleware
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
                case 'admin':
                    return $next($request);
                    break;
                case 'staff':
                    return $next($request);
                    break;
                case 'superadmin':
                    return $next($request);
                    break;
                default:
                    return redirect(env('APP_URL').'/');
                    break;
            }

        } else {
            return redirect(env('APP_URL').'/admin/login');
        }
    }
}
