<?php

namespace App\Services;

use App\Enums\FavoriteEnum;
use App\Repositories\UserRepository;
use App\Models\Favorite;
use App\Models\History;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User|Authenticatable
     */
    public function getCurrentUser(): User|Authenticatable
    {
        return $this->userRepository
            ->getCurrentUser();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request): array
    {
        return $this->userRepository
            ->create($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function authenticate(Request $request): array
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($data)) {

            return [
                'message' => trans('messages.token_generated'),
                'data' => [
                    'token' => Auth::user()
                        ->createToken('API')
                        ->accessToken,
                ],
            ];
        }

        return [
            'message' => trans('messages.invalid_credentials'),
        ];
    }

    /**
     * @return array
     */
    public function show(): array
    {
        $user = $this->getCurrentUser();

        return [
            'name' => $user->name,
            'email' => $user->email,
            'added' => $user->created_at->format('d/m/Y H:i:s'),
        ];
    }

    /**
     * @return array
     */
    public function history(): array
    {
        $user = $this->getCurrentUser();

        $data = [];

        /* @var History $history */

        foreach ($user->histories as $history) {

            $data[] = [
                'word' => $history->word
                    ->name,
                'added' => $history->created_at
                    ->format('d/m/Y H:i:s'),
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function favorites(): array
    {
        $user = $this->getCurrentUser();

        $favorites = $user->favorites
            ->where('status', FavoriteEnum::FAVORITED);

        $data = [];

        /* @var Favorite $favorite */

        foreach ($favorites as $favorite) {

            $data[] = [
                'word' => $favorite->word
                    ->name,
                'added' => $favorite->created_at
                    ->format('d/m/Y H:i:s'),
            ];
        }

        return $data;
    }
}
