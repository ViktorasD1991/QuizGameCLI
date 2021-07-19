<?php

namespace App\Console\Commands;

use App\Constants\Statuses;
use App\Repositories\QuestionsRepository;
use Illuminate\Console\Command;


class QuestionStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:interactive-stats-questions';

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
        $username = $this->ask('Which user`s stats you wish to see?');

        $allUserQuestions = $this->questionRepository->getAllUserQuestions($username);
        $answeredQuestions = $allUserQuestions->where('status', '!=', Statuses::NOT_ANSWERED);
        $correctlyAnsweredQuestions = $allUserQuestions->where('status', '=', Statuses::CORRECT);

        $this->table(
            ['Number of Questions', 'Questions answered', 'Questions correctly answered'],
            [[$allUserQuestions->count(), $answeredQuestions->count(), $correctlyAnsweredQuestions->count()]]
        );
    }
}
