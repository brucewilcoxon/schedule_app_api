<?php

namespace App\UseCases\Departure;

use App\Http\Requests\Departure\DepartureUpdateRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\Departure;

class DepartureUpdateAction
{
    public function __invoke(DepartureUpdateRequest $request, Departure $departure)
    {
        $validated = $request->validated();

        if ($request->user()->id !== $departure->user_id) {
            return response()->json([
                'message' => '出艇の編集をする権限がありません.'
            ], 403);
        }

        $departure->update($validated);

        return new SuccessResource('出艇の更新に成功しました');
    }
}