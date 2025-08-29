<?php

namespace App\UseCases\Question;

use App\Http\Requests\Question\QuestionShowRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;

class QuestionShowAction
{
    public function __invoke(QuestionShowRequest $request, Question $question)
    {
        $question->load(['user.userProfile','answers.user.userProfile']);

        return response()->json(new QuestionResource($question));
    }
}
