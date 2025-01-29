<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        return response()->json(Auth::check(), 401);

        if (Auth::check()) {
            $user = Auth::user();


            // Verificar si el usuario tiene el rol de "admin"
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'No tienes permisos suficientes'], 403);
            }

            // Si todo es correcto, continuar con la solicitud
            return $next($request);
        }

        // Si no está autenticado
        return response()->json(['message' => 'No autenticado'], 401);
    }
}
