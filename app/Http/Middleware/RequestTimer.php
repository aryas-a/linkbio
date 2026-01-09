<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestTimer
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        /** @var Response $response */
        $response = $next($request);

        $elapsedMs = (microtime(true) - $start) * 1000;
        $threshold = (int) env('REQUEST_TIMER_THRESHOLD_MS', 300);

        // Add header for visibility
        $response->headers->set('X-Response-Time', sprintf('%.1fms', $elapsedMs));

        if ($elapsedMs >= $threshold) {
            Log::warning('slow_request', [
                'method' => $request->getMethod(),
                'uri' => $request->getRequestUri(),
                'elapsed_ms' => (int) $elapsedMs,
                'ip' => $request->ip(),
                'user_id' => optional($request->user())->id,
            ]);
        }

        return $response;
    }
}
