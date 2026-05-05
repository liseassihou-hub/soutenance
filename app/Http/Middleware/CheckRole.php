<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // Vérifier si l'utilisateur a le bon rôle
        if (Auth::user()->role !== $role) {
            // Rediriger vers le dashboard approprié selon le rôle de l'utilisateur
            $userRole = Auth::user()->role;
            
            return match($userRole) {
                'admin' => redirect()->route('admin.dashboard')
                    ->with('error', 'Accès réservé aux agents.'),
                'agent' => redirect()->route('pebco.agent.dashboard')
                    ->with('error', 'Accès réservé aux administrateurs.'),
                default => redirect()->route('home')
                    ->with('error', 'Accès non autorisé.')
            };
        }

        return $next($request);
    }
}
