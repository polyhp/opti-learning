<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpleRoleCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Vérifier si l'utilisateur a le rôle requis
        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Accès non autorisé. Rôle requis: ' . $role);
        }

        return $next($request);
    }
}