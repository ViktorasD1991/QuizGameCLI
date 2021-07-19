<?php

namespace App\Console\Commands;

use App\Repositories\QuestionsRepository;
use App\Rules\CheckUserCreatingQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:interactive-create-questions';

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
        $password = $this->secret('Type your admin password', '',);

        $validator = Validator::make([
            'password' => $password,
        ], [
            'password' => [new CheckUserCreatingQuestion()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        } else {
            $question = $this->ask('Type your question.');
            $answer = $this->ask('Fill up the accepted answer to the question');

            $this->questionRepository->createQuestion($question, $answer);

            $this->info('Your question was created');
        }
    }
}
