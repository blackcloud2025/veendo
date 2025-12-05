<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RefreshUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario está autenticado, recarga sus datos de la BD
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $freshUser = \App\Models\User::find($userId);
            
            if ($freshUser) {
                // Re-autenticar con los datos frescos
                auth()->setUser($freshUser);
            }
        }

        return $next($request);
    }
}
