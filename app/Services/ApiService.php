<?php

namespace App\Services;

use App\Repositories\HistoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\WordRepository;
use Illuminate\Support\Facades\Http;

class ApiService
{
    private WordRepository $wordRepository;
    private UserRepository $userRepository;
    private HistoryRepository $historyRepository;

    /**
     * @param WordRepository $wordRepository
     * @param UserRepository $userRepository
     * @param HistoryRepository $historyRepository
     */
    public function __construct(
        WordRepository    $wordRepository,
        UserRepository    $userRepository,
        HistoryRepository $historyRepository
    )
    {
        $this->wordRepository = $wordRepository;

        $this->userRepository = $userRepository;

        $this->historyRepository = $historyRepository;
    }

    /**
     * @param string $wordSearch
     * @return array|array[]
     */
    public function getWord(string $wordSearch): array
    {
        $url = env('DICTIONARY_API_URL') . "$wordSearch";

        $response = Http::get($url);

        $data = $response->json();

        // Word Not Found
        if (isset($data['title'])
            && $data['title'] === trans('messages.no_definitions')) {

            return [
                'status'  => false,
                'message' => trans('messages.word_not_found'),
            ];
        }

        $user = $this->userRepository->getCurrentUser();

        $word = $this->wordRepository->get($wordSearch);

        $this->historyRepository->create($user->id, $word->id);

        $details = [];

        $meanings = $data[0]['meanings'];

        foreach ($meanings as $meaning) {

            foreach ($meaning['definitions'] as $data) {

                $details[] = $data['definition'];
            }
        }

        return [
            'details' => $details,
        ];
    }
}
