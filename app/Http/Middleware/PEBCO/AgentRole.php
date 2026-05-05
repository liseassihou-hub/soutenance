<?php

namespace App\Http\Middleware\PEBCO;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentRole
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
        // Vérifier l'authentification par session (notre système)
        if (!session()->has('user') || session('guard') !== 'agent') {
            return redirect()->route('agent.connexion')
                ->with('error', 'Accès réservé aux agents. Veuillez vous connecter.');
        }

        return $next($request);
    }
}
