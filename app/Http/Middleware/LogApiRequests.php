<?php

namespace App\Http\Middleware;

use App\Models\Api\ApiLog;
use Closure;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->instance('api_log', ApiLog::fromImcomingRequest($request));

        return $next($request);
    }
}
