<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'admin est connecté
        if (!Auth::guard('admin')->check()) {
            // Rediriger vers la page de connexion admin avec un message
            return redirect()->route('login.form')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // Si connecté, continuer la requête
        return $next($request);
    }
}
