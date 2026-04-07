<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->user();

        if (!$company || !$company->is_active) {
            return response()->json(['error' => 'Empresa inactiva'], 403);
        }

        if ($company->expires_at && now()->greaterThan($company->expires_at)) {
            return response()->json(['error' => 'Token expirado'], 403);
        }

        return $next($request);




        // $header = $request->header('Authorization');

        // if (!$header || !str_starts_with($header, 'Bearer ')) {
        //     return response()->json(['message' => 'Token requerido'], 401);
        // }

        // $token = str_replace('Bearer ', '', $header);

        // // Buscar token en Sanctum
        // $accessToken = PersonalAccessToken::findToken($token);

        // if (!$accessToken) {
        //     return response()->json(['message' => 'Token inválido'], 401);
        // }

        // // Validar que sea una empresa
        // $company = $accessToken->tokenable;

        // if (!$company instanceof Company) {
        //     return response()->json(['message' => 'No autorizado'], 403);
        // }

        // // Inyectar empresa en request
        // $request->merge(['company' => $company]);

        // return $next($request);
    }
}
