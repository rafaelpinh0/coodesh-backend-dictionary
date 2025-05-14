<?php

namespace App\Services;

use App\Models\Word;
use App\Repositories\WordRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WordService
{
    private WordRepository $wordRepository;

    /**
     * @param WordRepository $wordRepository
     */
    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    /**
     * @param array $words
     * @return void
     */
    public function massCreate(array $words): void
    {
        $words = array_keys($words);

        foreach ($words as $word) {

            $this->wordRepository->create($word);
        }
    }

    /**
     * @param string $word
     * @return Word|Builder
     */
    public function get(string $word): Word|Builder
    {
        return $this->wordRepository->get($word);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function all(Request $request): array
    {
        $search = $request->input('search');

        $limit = $request->input('limit');

        $words = $this->wordRepository->all($search, $limit);

        if ($limit) {

            return [
                'results' => $words->pluck('name')
                    ->toArray(),
                'totalDocs' => $words->total(),
                'page' => $words->currentPage(),
                'totalPages' => $words->lastPage(),
                'hasNext' => $words->hasMorePages(),
                'hasPrev' => $words->currentPage() > 1,
            ];
        }

        return [
            'results' => $words->pluck('name')
                ->toArray(),
            'totalDocs' => $words->count(),
            'page' => 1,
            'totalPages' => 1,
            'hasNext' => false,
            'hasPrev' => false,
        ];
    }
}
