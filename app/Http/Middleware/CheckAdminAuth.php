<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'admin est connecté
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.form')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        return $next($request);
    }
}
