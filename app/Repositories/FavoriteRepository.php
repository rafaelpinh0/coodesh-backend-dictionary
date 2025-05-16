<?php

namespace App\Repositories;

use App\Enums\FavoriteEnum;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FavoriteRepository
{
    /**
     * @param int $userId
     * @param int $wordId
     * @return Builder|Model|object|null
     */
    public function get(int $userId, int $wordId): Builder|Model|null
    {
        return Favorite::query()
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->first();
    }

    /**
     * @param int $userId
     * @param int $wordId
     * @return array
     */
    public function create(int $userId, int $wordId): array
    {
        $favorite = $this->get($userId, $wordId);

        if ($favorite) {

            if ($favorite->status->isUnfavorited()) {

                $favorite->status = FavoriteEnum::FAVORITED;

                $favorite->save();

                return [
                    'message' => trans('messages.favorite_word'),
                ];
            }

            return [
                'message' => trans('messages.already_favorite'),
            ];
        }

        $favorite = new Favorite();

        $favorite->user_id = $userId;

        $favorite->word_id = $wordId;

        $favorite->status = FavoriteEnum::FAVORITED;

        $favorite->save();

        return [
            'message' => trans('messages.favorite_word'),
        ];
    }

    /**
     * @param int $userId
     * @param int $wordId
     * @return array
     */
    public function delete(int $userId, int $wordId): array
    {
        $favorite = $this->get($userId, $wordId);

        if ($favorite) {

            if ($favorite->status->isUnfavorited()) {

                return [
                    'message' => trans('messages.already_unfavorite'),
                ];
            }

            $favorite->status = FavoriteEnum::UNFAVORITED;

            $favorite->save();

            return [
                'message' => trans('messages.unfavorite_word'),
            ];
        }

        return [
            'message' => trans('messages.not_favorite'),
        ];
    }
}
