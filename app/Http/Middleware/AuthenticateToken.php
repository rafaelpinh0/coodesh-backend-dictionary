<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthenticateToken
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
        try {

            $authenticated = Auth::guard('api')->user();

            if (!$authenticated) {

                return response()->json([
                    'message' => trans('messages.invalid_token'),
                ]);

            } else {

                $response = $next($request);

                $data = $response->getOriginalContent();

                return response()->json($data);
            }

        } catch (Throwable $exception) {

            Log::error($exception->getMessage());

            return response()->json([
                'message' => trans('messages.something_wrong'),
            ]);
        }
    }
}
