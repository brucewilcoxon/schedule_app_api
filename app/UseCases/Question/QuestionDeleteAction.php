<?php

namespace App\UseCases\Question;

use App\Http\Resources\Common\SuccessResource;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionDeleteAction
{
    public function __invoke(Question $question)
    {
        $user = Auth::user();

        if ($user->id !== $question->user_id) {
            return response()->json([
                'message' => '削除する権限がありません',
            ], 403);
        }

        $question->delete();

        return new SuccessResource('質問の削除に成功しました');
    }
}
