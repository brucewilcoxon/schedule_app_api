<?php

namespace App\UseCases\WindNote;

use App\Http\Requests\WindNote\WindNoteStoreRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\WindNote;

class WindNoteStoreAction
{
    public function __invoke(WindNoteStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        WindNote::create($validated);

        return new SuccessResource('ノートの作成に成功しました');
    }
}
