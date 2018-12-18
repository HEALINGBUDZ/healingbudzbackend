<?php

namespace App\Http\Middleware;

//use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckUserName {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::user() && !Auth::user()->first_name) {
            if(\Request::segment(1) != 'user-nickname'){
                if(\Request::segment(1) == 'update_username'){
                    return $next($request);
                }
            return Redirect::to('user-nickname');
        }}
        return $next($request);
    }

}
