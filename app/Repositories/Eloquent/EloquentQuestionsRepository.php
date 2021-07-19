<?php

namespace App\Repositories\Eloquent;

use App\Models\Questions;
use App\Models\QuestionsStatus;
use App\Repositories\QuestionsRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Constants\Statuses;

class EloquentQuestionsRepository implements QuestionsRepository
{
    /**
     * @var Questions $questionsModel
     */
    private Questions $questionsModel;

    /**
     * @var QuestionsStatus $questionsStatusModel
     */
    private QuestionsStatus $questionsStatusModel;


    /**
     * EloquentQuestionsRepository constructor
     *
     * @param Questions $questionsModel
     * @param QuestionsStatus $questionsStatusModel
     */
    public function __construct(Questions $questionsModel, QuestionsStatus $questionsStatusModel)
    {
        $this->questionsModel = $questionsModel;
        $this->questionsStatusModel = $questionsStatusModel;
    }

    /**
     * Creates a new question
     *
     * @param string $question
     * @param string $answer
     *
     * @return Questions
     */
    public function createQuestion(string $question, string $answer): Questions
    {
        return $this->questionsModel->create([
            'question' => $question,
            'answer' => $answer
        ]);
    }

    /**
     * Populate questions when user starts practising
     *
     * @param string $username
     *
     * @return Collection
     */
    public function populateQuestions(string $username): Collection
    {
        $questions = $this->questionsModel->get();

        $questions->each(function ($question) use ($username) {
            $userQuestion = $this->questionsStatusModel
                ->where('username', '=', $username)
                ->where('question_id', '=', $question->id)
                ->first();

            if (empty($userQuestion)) {
                $this->questionsStatusModel->create([
                    'username' => $username,
                    'question_id' => $question->id,
                    'status' => Statuses::NOT_ANSWERED,
                ]);
            }
        });


        return $this->questionsModel->with(['status' => function ($query) use ($username) {
            $query->where('username', '=', $username);
        }])->get();
    }

    /**
     * Retrieve the correctly answered questions of a user
     *
     * @param string $username
     *
     * @return Collection
     */
    public function getAnsweredUserQuestions(string $username): Collection
    {
        return $this->questionsModel->whereHas('status', function (Builder $query) use ($username) {
            $query->where('username', '=', $username)
                ->where('status', '=', Statuses::CORRECT);
        })->get();
    }

    /**
     * Retrieve a single question
     *
     * @param int $questionId
     *
     * @return Questions
     */
    public function getSingleQuestion(int $questionId): Questions
    {
        return $this->questionsModel->where('id', '=', $questionId)->first();
    }

    /**
     * Stores user's answer
     *
     * @param string $username
     * @param int $questionId
     * @param string $status
     *
     * @return Questions
     */
    public function storeAnswer(string $username, int $questionId, string $status): Questions
    {
        $this->questionsStatusModel
            ->where('username', '=', $username)
            ->where('question_id', '=', $questionId)
            ->update([
                'status' => $status
            ]);

        return $this->questionsModel->where('id', '=', $questionId)->first();
    }

    /**
     * Retrieves status of a question based on user answering
     *
     * @param int $questionId
     * @param string $userName
     *
     * @return QuestionsStatus
     */
    public function getQuestionStatus(int $questionId, string $userName): QuestionsStatus
    {
        return $this->questionsStatusModel
            ->where('username', '=', $userName)
            ->where('question_id', '=', $questionId)
            ->first();
    }

    /**
     * Retrieves all questions that belong to a user
     *
     * @param string $username
     *
     * @return Collection
     */
    public function getAllUserQuestions(string $username): Collection
    {
        return $this->questionsStatusModel->where('username', '=', $username)->get();
    }

    /**
     * Removes all user questions
     *
     * @param string $username
     *
     * @return Collection
     */
    public function resetQuestions(string $username): Collection
    {
        $this->questionsStatusModel->where('username','=',$username)->delete();

        return collect([]);
    }
}
