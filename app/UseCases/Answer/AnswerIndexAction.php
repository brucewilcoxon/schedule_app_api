<?php

namespace App\UseCases\Answer;

use App\Http\Requests\Answer\AnswerIndexRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;

class AnswerIndexAction
{
    public function __invoke(AnswerIndexRequest $request)
    {
        $userId = $request->query('user_id');
        $query = Answer::with(['user.userProfile', 'question.user.userProfile']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $answers = $query->orderBy('created_at', 'desc')->get();

        return response()->json(AnswerResource::collection($answers));
    }
}