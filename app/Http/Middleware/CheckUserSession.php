<?php

namespace App\Http\Middleware;

use Closure;
use App\LoginUsers;
use Illuminate\Support\Facades\Response;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckUserSession {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $headers = getallheaders();
        if (isset($headers['session_token'])) {
            $checksession = LoginUsers::where('session_key', $headers['session_token'])->first();
            if ($checksession) {
                LoginUsers::where('session_key', $headers['session_token'])->update(['is_online' => 1]);
                $user = User::find($checksession->user_id);
                Auth::login($user);
                return $next($request);
            } else {
                return sendError('Session Expired', 404);
                //return Response::json(array('status' => 'error', 'errorMessage' => 'Session Expired', 'errorCode' => 400), 400);
            }
        } else {
            return sendError('Session Expired', 404);
            //return Response::json(array('status' => 'error', 'errorMessage' => 'Session Expired', 'errorCode' => 400), 400);
        }
    }

}
