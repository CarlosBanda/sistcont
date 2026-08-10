<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * EnsureCompanyTenant
 * 
 * Middleware de multitenancy que garantiza el aislamiento de datos por empresa.
 * 
 * Funciones:
 * 1. Verifica que el usuario esté autenticado (via guard api o via cookie JWT)
 * 2. Verifica que el usuario tenga una empresa (company_id) asignada
 * 3. Inyecta el company_id en el request como 'tenant_company_id'
 *    para que los controladores lo usen al filtrar consultas
 */
class EnsureCompanyTenant
{
    /**
     * Procesar la petición verificando el tenant.
     *
     * @param Request $request Petición entrante
     * @param Closure $next Siguiente middleware en la cadena
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Intentar obtener usuario del guard API (ya autenticado por JwtMiddleware)
        $user = auth('api')->user();

        // Si no se encontró, intentar autenticar con la cookie (para rutas web)
        if (!$user) {
            try {
                $token = $request->cookie('token') ?? $request->bearerToken();
                if ($token) {
                    $user = JWTAuth::setToken($token)->authenticate();
                }
            } catch (\Exception $e) {
                $user = null;
            }
        }

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autenticado'], 401);
            }
            return redirect('/login');
        }

        // Verificar que el usuario tenga empresa asignada
        $companyId = $user->company_id;

        if (!$companyId) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Usuario sin empresa asignada'], 403);
            }
            abort(403, 'Usuario sin empresa asignada');
        }

        // Inyectar company_id en el request para uso en controladores
        $request->merge(['tenant_company_id' => $companyId]);

        return $next($request);
    }
}
