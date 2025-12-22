<?php

namespace App\UseCases\RepairTypeOption;

use App\Http\Requests\RepairTypeOption\RepairTypeOptionStoreRequest;
use App\Models\RepairTypeOption;
use Illuminate\Http\JsonResponse;

class RepairTypeOptionStoreAction
{
    public function __invoke(RepairTypeOptionStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        // If order is not provided, set it to the max order + 1
        if (! isset($data['order'])) {
            $maxOrder = RepairTypeOption::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }

        $option = RepairTypeOption::create($data);

        return response()->json([
            'message' => '修理の種類が正常に追加されました',
            'data' => $option,
            'success' => true,
        ], 201);
    }
}
