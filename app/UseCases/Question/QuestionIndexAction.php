<?php

namespace App\UseCases\Question;

use App\Http\Requests\Question\QuestionIndexRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\WindNote;

class QuestionIndexAction
{
    public function __invoke(QuestionIndexRequest $request)
    {
        $userId = $request->query('user_id');
        $query = Question::with(['user.userProfile','answers.user.userProfile']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $questions = $query->orderBy('created_at', 'desc')->get();

        return response()->json(QuestionResource::collection($questions));
    }
}
