<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class FormatQuestions
{
    public static function format(Collection $questions): array
    {
        $formattedQuestions = $questions->map(function ($item, $key) {
            return [
                'question_id' => $item->id,
                'question' => $item->question,
                'status' => $item->status->status,
            ];
        });

        return $formattedQuestions->toArray();

    }
}
