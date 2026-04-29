<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\UserType;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->type === UserType::Client) {
            return $next($request);
        }

        if (auth()->check() && auth()->user()->type === UserType::Agent) {
            return redirect()->route('dashboard');
        }

        abort(403, 'Unauthorized access to client resources.');
    }
}
