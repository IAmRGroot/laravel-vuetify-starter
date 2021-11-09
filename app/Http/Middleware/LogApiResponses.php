<?php

namespace App\Http\Middleware;

use App\Models\Api\ApiLog;
use Closure;
use Illuminate\Http\Response;

class LogApiResponses
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
        /** @var Response $response */
        $response = $next($request);

        /** @var ApiLog $api_log */
        $api_log = resolve('api_log');
        $api_log->updateFromHttpResponse($response);

        return $response;
    }
}
