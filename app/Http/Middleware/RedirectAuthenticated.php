<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticated
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
        // Si l'utilisateur est déjà connecté, le rediriger vers son dashboard approprié
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        if (Auth::guard('agent')->check()) {
            return redirect()->route('pebco.agent.dashboard');
        }
        
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
