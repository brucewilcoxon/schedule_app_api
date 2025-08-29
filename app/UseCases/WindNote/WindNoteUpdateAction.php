<?php

namespace App\UseCases\WindNote;

use App\Http\Requests\WindNote\WindNoteUpdateRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\WindNote;

class WindNoteUpdateAction
{
    public function __invoke(WindNoteUpdateRequest $request, WindNote $windNote)
    {
        $validated = $request->validated();

        if ($request->user()->id !== $windNote->user_id) {
            return response()->json([
                'message' =>  'ノートを編集する権限がありません'
                ], 403);
        }

        $windNote->update($validated);

        return new SuccessResource('ノートの更新に成功しました');
    }
}
