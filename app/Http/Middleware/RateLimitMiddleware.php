<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RateLimitMiddleware
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();
        $key = "user:{$userId}:actions";
        $limit = 5; // requests per minute

        $count = Cache::get($key, 0);

        if ($count >= $limit) {
            abort(429, 'Too many requests');
        }

        Cache::put($key, $count + 1, now()->addMinute());

        return $next($request);
    }
}
