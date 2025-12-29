<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActionLoggingMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('User action', [
            'user_id'   => Auth::id(),
            'path'      => $request->path(),
            'method'    => $request->method(),
            'timestamp' => now(),
        ]);

        return $next($request);
    }
}
