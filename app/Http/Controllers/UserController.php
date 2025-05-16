<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {

            return response()
                ->json($this->userService
                    ->create($request));

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        try {

            return response()
                ->json($this->userService
                    ->authenticate($request));

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        try {

            return response()
                ->json($this->userService
                    ->show());

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        try {

            return response()->json($this->userService
                ->history());

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function favorites(): JsonResponse
    {
        try {

            return response()
                ->json($this->userService
                    ->favorites());

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }
}
