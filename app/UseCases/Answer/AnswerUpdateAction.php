<?php

namespace App\UseCases\Answer;

use App\Http\Requests\Answer\AnswerUpdateRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\Answer;

class AnswerUpdateAction
{
    public function __invoke(AnswerUpdateRequest $request, Answer $answer)
    {
        $validated = $request->validated();

        if ($request->user()->id !== $answer->user_id) {
            return response()->json([
                'message' => '回答の編集をする権限がありません.'
            ], 403);
        }

        $answer->update($validated);

        return new SuccessResource('回答の更新に成功しました');
    }
}
