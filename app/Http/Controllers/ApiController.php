<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Services\FavoriteService;
use App\Services\UserService;
use App\Services\WordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiController extends Controller
{
    private ApiService $apiService;
    private WordService $wordService;
    private FavoriteService $favoriteService;
    private UserService $userService;

    /**
     * @param ApiService $apiService
     * @param WordService $wordService
     * @param FavoriteService $favoriteService
     * @param UserService $userService
     */
    public function __construct(
        ApiService      $apiService,
        WordService     $wordService,
        FavoriteService $favoriteService,
        UserService     $userService
    )
    {
        $this->apiService = $apiService;

        $this->wordService = $wordService;

        $this->favoriteService = $favoriteService;

        $this->userService = $userService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => trans('messages.challenge'),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        try {

            return response()
                ->json($this->wordService
                    ->all($request));

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @param string $word
     * @return JsonResponse
     */
    public function search(string $word): JsonResponse
    {
        try {

            return response()
                ->json($this->apiService
                    ->getWord($word));

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @param string $word
     * @return JsonResponse
     */
    public function favorite(string $word): JsonResponse
    {
        try {

            $word = $this->wordService
                ->get($word);

            if ($word) {

                $user = $this->userService
                    ->getCurrentUser();

                return response()
                    ->json($this->favoriteService
                        ->create($user->id, $word->id));
            }

            return response()->json([
                'message' => trans('messages.word_not_found')
            ]);

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }

    /**
     * @param string $word
     * @return JsonResponse
     */
    public function unfavorite(string $word): JsonResponse
    {
        try {

            $word = $this->wordService
                ->get($word);

            if ($word) {

                $user = $this->userService
                    ->getCurrentUser();

                return response()
                    ->json($this->favoriteService->delete($user->id, $word->id));
            }

            return response()->json([
                'message' => trans('messages.word_not_found')
            ]);

        } catch (Throwable $exception) {

            Log::error($exception);

            return response()->json([
                'status' => false,
                'message' => trans('messages.something_wrong'),
            ], 400);
        }
    }
}
