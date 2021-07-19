<?php

namespace App\Console\Commands;

use App\Constants\Statuses;
use App\Helpers\FormatQuestions;
use App\Models\Questions;
use App\Repositories\QuestionsRepository;
use App\Rules\CheckUserCreatingQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class Quiz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Question-answer panel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        do {
            $menu = $this->choice(
                'Which category you would like to choose?',
                ['Create a question', 'List all questions', 'Practise', 'Stats', 'Reset', 'Exit'],
            );

            if ($menu == "Create a question") {
                $this->call('qanda:interactive-create-questions');
            } else if ($menu == "List all questions") {
                $this->call('qanda:interactive-list-questions');
            } else if ($menu == "Practise") {
                $this->call('qanda:interactive-practise-questions');
            } else if ($menu == 'Stats') {
                $this->call('qanda:interactive-stats-questions');
            } else if ($menu == 'Reset') {
                $this->call('qanda:interactive-reset-questions');
            }
        } while ($menu !== 'Exit');
    }
}
