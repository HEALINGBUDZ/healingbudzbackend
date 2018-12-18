<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Redirect;

class CheckAgent {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $agent = new Agent();
        $platform = $agent->platform();
        $data['agent'] = $platform;
        if(\Illuminate\Support\Facades\Auth::user()){
            \App\LoginUsers::where(array('user_id' => \Illuminate\Support\Facades\Auth::user()->id, 'device_id' => \Request::ip(), 'device_type' => 'web'))->update(['is_online' => 1]); 
        }
        if ($platform == 'AndroidOS' || $platform == 'iOS') { 
            return Redirect::to('mobileSupport')->with('agent', $platform);
        }
        return $next($request);
    }

}
