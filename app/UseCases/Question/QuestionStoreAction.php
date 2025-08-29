<?php

namespace App\UseCases\Question;

use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\Question;

class QuestionStoreAction
{
    public function __invoke(QuestionStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $question = Question::create($validated);

        return new SuccessResource('質問の作成に成功しました');
    }
}
