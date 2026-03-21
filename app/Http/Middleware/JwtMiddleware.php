<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->cookie('token');

            if (!$token) {
                return redirect('/login');
            }

            // auth('api')->setToken($token)->authenticate();
            JWTAuth::setToken($token)->authenticate();

        } catch (Exception $e) {

            return redirect('/login');

        }

        return $next($request);
    }
}