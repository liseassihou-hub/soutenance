<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientStatusCheck
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
        // Vérifier si c'est un client connecté
        if (session()->has('user') && session('guard') === 'client') {
            $user = session('user');
            
            // Si le client est en session (simulé)
            if (isset($user->statut) && $user->statut === 'bloque') {
                // Déconnecter le client
                session()->forget(['user', 'guard']);
                session()->invalidate();
                session()->regenerateToken();
                
                return redirect()->route('client.login')
                    ->with('error', 'Votre compte a été bloqué. Veuillez contacter l\'agent.');
            }
            
            // Si le client est en base de données
            if (isset($user->id)) {
                try {
                    $client = \App\Models\Client::find($user->id);
                    if ($client && $client->statut === 'bloque') {
                        // Déconnecter le client
                        session()->forget(['user', 'guard']);
                        session()->invalidate();
                        session()->regenerateToken();
                        
                        return redirect()->route('client.login')
                            ->with('error', 'Votre compte a été bloqué. Veuillez contacter l\'agent.');
                    }
                } catch (\Exception $e) {
                    // En cas d'erreur, continuer normalement
                }
            }
        }

        return $next($request);
    }
}
