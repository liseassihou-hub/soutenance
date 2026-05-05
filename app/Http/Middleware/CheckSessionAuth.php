<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSessionAuth
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
        if (!session()->has('user')) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        return $next($request);
    }
}
