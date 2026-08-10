<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

/**
 * JwtMiddleware
 * 
 * Middleware de autenticación JWT para rutas web.
 * Busca el token en este orden:
 * 1. Cookie 'token' (seteada por el login desde JS)
 * 2. Header Authorization: Bearer (para compatibilidad con API)
 * 
 * Si no se encuentra o es inválido, redirige a /login.
 */
class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Buscar token en cookie primero, luego en header Authorization
            $token = $request->cookie('token') ?? $request->bearerToken();

            if (!$token) {
                return redirect('/login');
            }

            // Autenticar usuario con el token encontrado
            JWTAuth::setToken($token)->authenticate();

        } catch (Exception $e) {
            return redirect('/login');
        }

        return $next($request);
    }
}
