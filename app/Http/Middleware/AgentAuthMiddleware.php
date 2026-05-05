<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('agent_id')) {
            return redirect()->route('agent.login');
        }

        return $next($request);
    }
}
