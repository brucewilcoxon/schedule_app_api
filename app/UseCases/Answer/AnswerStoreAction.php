<?php

namespace App\UseCases\Answer;

use App\Http\Requests\Answer\AnswerStoreRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\Answer;

class AnswerStoreAction
{
    public function __invoke(AnswerStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        Answer::create($validated);

        return new SuccessResource('回答の作成に成功しました');
    }
}
