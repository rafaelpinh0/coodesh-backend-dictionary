<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WordService;

class FillWordsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-words-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for fill "words" table.';

    /**
     * Execute the console command.
     */
    public function handle(WordService $wordService): void
    {
        $words = file_get_contents(base_path('words_dictionary.json'));

        $words = json_decode($words, true);

        $wordService->massCreate($words);
    }
}
