<?php

namespace App\Repositories;

use App\Models\Word;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class WordRepository
{
    /**
     * @param string $word
     * @return void
     */
    public function create(string $word): void
    {
        Word::create([
            'word' => $word,
        ]);
    }

    /**
     * @param string $word
     * @return Word|Builder|null
     */
    public function get(string $word): Word|Builder|null
    {
        return Word::query()
            ->where('word', $word)
            ->first();
    }

    /**
     * @param string|null $search
     * @param string|null $limit
     * @return LengthAwarePaginator|Builder|Collection
     */
    public function all(?string $search, ?string $limit): LengthAwarePaginator|Builder|Collection
    {
        $words = Word::query();

        if ($search) {

            $words = $words->where('word', 'like', "%$search%");
        }

        return $limit
            ? $words->paginate($limit)
            : $words->get();
    }
}
