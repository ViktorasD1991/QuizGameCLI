<?php

namespace App\Console\Commands;

use App\Models\Questions;
use App\Repositories\QuestionsRepository;
use Illuminate\Console\Command;


class DeleteQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:interactive-delete-questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Question-answer panel';

    /**
     * Repositories needed for controller
     **/
    private $questionRepository;

    /**
     * Create a new command instance.
     *
     * @param QuestionsRepository $questionsRepository
     *
     * @return void
     */
    public function __construct(QuestionsRepository $questionsRepository)
    {
        parent::__construct();
        $this->questionRepository = $questionsRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
            ['Question Id', 'Question'],
            Questions::all(['id', 'question'])->toArray()
        );

        $questionId = $this->ask('Fill in the question ID you would like to delete.');

        $this->questionRepository->deleteQuestion($questionId);
    }
}
