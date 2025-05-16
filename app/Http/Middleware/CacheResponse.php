<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $key = 'ResponseCache:' . md5($request->fullUrl());

        $start = microtime(true);

        if (Cache::has($key)) {

            $cached = Cache::get($key);

            $headers = array_merge(
                $cached['Headers'],
                ['X-Cache' => 'HIT', 'X-Response-Time' => round((microtime(true) - $start) * 1000) . 'ms']
            );

            return response()->json($cached['Body'], 200, $headers);
        }

        $response = $next($request);

        $data = [
            'Headers' => $response->headers->all(),
            'Body' => $response->getOriginalContent(),
        ];

        Cache::put($key, $data, now()->addMinutes(60));

        $response->headers->set('X-Cache', 'MISS');

        $response->headers->set('X-Response-Time', round((microtime(true) - $start) * 1000) . 'ms');

        return $response;
    }
}
