<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class FormatQuestions
{
    public static function format(Collection $questions): array
    {
        $formattedQuestions = [];

        foreach ($questions as $question) {
            $formattedQuestions[] = [
                'question_id' => $question->id,
                'question' => $question->question,
                'status' => $question->status->status,
            ];
        }
        return $formattedQuestions;
    }
}
