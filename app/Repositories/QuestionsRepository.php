<?php

namespace App\Repositories;

use App\Models\Questions;
use App\Models\QuestionsStatus;
use Illuminate\Support\Collection;

interface QuestionsRepository
{
    public function createQuestion(string $question, string $answer): Questions;

    public function populateQuestions(string $username): Collection;

    public function getAnsweredUserQuestions(string $username): Collection;

    public function getSingleQuestion(int $questionId): Questions;

    public function storeAnswer(string $username, int $questionId, string $status): Questions;

    public function getQuestionStatus(int $questionId, string $userName): QuestionsStatus;

    public function getAllUserQuestions(string $username): Collection;

    public function resetQuestions(string $username): Collection;
}
