<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\UserType;

class AgentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->type === UserType::Agent) {
            return $next($request);
        }

        if (auth()->check() && auth()->user()->type === UserType::Client) {
            return redirect()->route('client.dashboard');
        }

        abort(403, 'Unauthorized access to agent resources.');
    }
}
