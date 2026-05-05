<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGuard
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
        // Vérifier si l'utilisateur est connecté avec le guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter en tant qu\'administrateur.');
        }

        // Vérifier que l'utilisateur a le rôle admin
        $user = Auth::guard('admin')->user();
        if ($user->role !== 'admin') {
            Auth::guard('admin')->logout();
            return redirect()->route('login')
                ->with('error', 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
