<?php

namespace App\Repositories;

use App\Models\History;
use Illuminate\Database\Eloquent\Builder;

class HistoryRepository
{
    /**
     * @param int $userId
     * @param int $wordId
     * @return Builder|History|null
     */
    public function get(int $userId, int $wordId): Builder|History|null
    {
        return History::query()
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->first();
    }

    /**
     * @param int $userId
     * @param int $wordId
     * @return void
     */
    public function create(int $userId, int $wordId): void
    {
        $history = $this->get($userId, $wordId);

        if (!$history) {

            $history = new History();

            $history->user_id = $userId;

            $history->word_id = $wordId;

            $history->save();
        }
    }
}
