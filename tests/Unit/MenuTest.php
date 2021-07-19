<?php

namespace Tests\Unit;

use App\Constants\Statuses;
use App\Models\Questions;
use App\Models\QuestionsStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test for question listing
     *
     * @return void
     */
    public function testQuestionList()
    {
        $this->artisan('qanda:interactive-list-questions')
            ->expectsTable(['Questions', 'Answers'], []);
    }

    /**
     * Test for creating a new question
     *
     * @return void
     */
    public function testCreateQuestion()
    {
        $this->artisan('qanda:interactive-create-questions')
            ->expectsQuestion('Type your admin password', 'iamadmin')
            ->expectsQuestion('Type your question.', 'This is just a random question with no answer')
            ->expectsQuestion('Fill up the accepted answer to the question', 'random answer')
            ->expectsOutput('Your question was created');
    }

    /**
     * Test for admin validation upon creating a question
     *
     * @return void
     */
    public function testAdminValidation()
    {
        $this->artisan('qanda:interactive-create-questions')
            ->expectsQuestion('Type your admin password', 'randompassword')
            ->expectsOutput('You are not authorized to create a new question.');
    }

    /**
     * Test for answering a question
     *
     * @return void
     */
    public function testPractiseQuestions()
    {
        $answer = $this->faker->paragraph;
        $questionText = $this->faker->paragraph;

        $question = Questions::create([
            'question' => $questionText,
            'answer' => $answer,
        ]);

        $this->artisan('qanda:interactive-practise-questions')
            ->expectsQuestion('Fill in your name to proceed.', $this->faker->name)
            ->expectsQuestion('Type the question number you wish to answer. Remember that correctly answered questions can not be selected. Type EXIT in case you want to go back to manin menu', $question->id)
            ->expectsQuestion($questionText, $answer)
            ->expectsOutput('Correct Answer');
    }

    /**
     * Test for showing question status
     *
     * @return void
     */
    public function testQuestionStats()
    {
        $user = $this->faker->name;

        $question = Questions::create([
            'question' => $this->faker->paragraph,
            'answer' => $this->faker->paragraph,
        ]);

        QuestionsStatus::create([
            'question_id' => $question->id,
            'username' => $user,
            'status' => Statuses::INCORRECT
        ]);

        $this->artisan('qanda:interactive-stats-questions')
            ->expectsQuestion('Which user`s stats you wish to see?', $user)
            ->expectsTable([['Number of Questions', 'Questions answered', 'Questions correctly answered']], [[1, 1, 0]]);
    }

    /**
     * Test for resseting questions
     *
     * @return void
     */
    public function testRestQuestions()
    {
        $user = $this->faker->name;

        $this->artisan('qanda:interactive-reset-questions')
            ->expectsQuestion('Type in the username you want to reset', $user)
            ->expectsOutput("User {$user} has been truncated");
    }
}
