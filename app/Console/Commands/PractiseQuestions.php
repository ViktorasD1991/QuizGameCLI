<?php

namespace App\Console\Commands;

use App\Constants\Statuses;
use App\Helpers\FormatQuestions;
use App\Repositories\QuestionsRepository;
use Illuminate\Console\Command;

class PractiseQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:interactive-practise-questions';

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
        $username = $this->ask('Fill in your name to proceed.');

        $questions = $this->questionRepository->populateQuestions($username);
        $formattedQuestions = FormatQuestions::format($questions);
        $this->table(
            ['Question Number', 'Questions', 'Status'],
            $formattedQuestions
        );

        $bar = $this->output->createProgressBar($questions->count());
        $bar->start();

        $existingAnsweredQuestions = $this->questionRepository->getAnsweredUserQuestions($username);

        $answeredQuestions = $existingAnsweredQuestions->count();
        sleep(1);
        $bar->advance($answeredQuestions);
        do {
            $questionId = $this->ask('Type the question number you wish to answer. Remember that correctly answered questions can not be selected. Type EXIT in case you want to go back to manin menu');

            if ($questionId == 'EXIT') {
                break;
            }
            $singleQuestion = $this->questionRepository->getSingleQuestion($questionId);

            $questionStatus = $this->questionRepository->getQuestionStatus($questionId, $username);

            if ($questionStatus->status == Statuses::CORRECT) {
                $this->info('You can not answer a correct question. Pick a different one.');
            } else {
                $userAnswer = $this->ask($singleQuestion->question);

                if ($userAnswer == $singleQuestion->answer) {
                    $status = Statuses::CORRECT;
                    $this->info('Correct Answer');
                    $answeredQuestions++;
                    $bar->advance();
                } else {
                    $status = Statuses::INCORRECT;
                    $this->info('Incorrect Answer');
                }

                $this->questionRepository->storeAnswer($username, $questionId, $status);
            }

        } while ($questions->count() != $answeredQuestions);


        $bar->finish();
    }
}
