<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SetSessionCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard && isset(Config::get('session.guard_cookies')[$guard])) {
            $cookieName = Config::get('session.guard_cookies')[$guard];
            
            // Set session cookie name for this guard
            Config::set('session.cookie', $cookieName);
        }

        return $next($request);
    }
}
