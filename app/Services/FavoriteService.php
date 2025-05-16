<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;

class FavoriteService
{
    private FavoriteRepository $favoriteRepository;

    /**
     * @param FavoriteRepository $favoriteRepository
     */
    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * @param int $userId
     * @param int $wordId
     * @return array
     */
    public function create(int $userId, int $wordId): array
    {
        return $this->favoriteRepository
            ->create($userId, $wordId);
    }

    /**
     * @param int $userId
     * @param int $wordId
     * @return array
     */
    public function delete(int $userId, int $wordId): array
    {
        return $this->favoriteRepository
            ->delete($userId, $wordId);
    }
}
