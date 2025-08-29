<?php

namespace App\UseCases\RefrigerantWorkplace;

use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceDeleteRequest;
use Illuminate\Http\JsonResponse;
use App\Models\RefrigerantWorkplace;

class RefrigerantWorkplaceDeleteAction
{
    public function __invoke(RefrigerantWorkplaceDeleteRequest $request, $id): JsonResponse
    {
        $item = RefrigerantWorkplace::findOrFail($id);
        $item->delete();

        return response()->json(['message' => '削除しました']);
    }
}