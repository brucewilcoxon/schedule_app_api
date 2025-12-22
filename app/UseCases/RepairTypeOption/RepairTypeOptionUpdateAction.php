<?php

namespace App\UseCases\RepairTypeOption;

use App\Http\Requests\RepairTypeOption\RepairTypeOptionUpdateRequest;
use App\Models\RepairTypeOption;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class RepairTypeOptionUpdateAction
{
    public function __invoke(RepairTypeOptionUpdateRequest $request, $id): JsonResponse
    {
        try {
            $option = RepairTypeOption::findOrFail($id);
            $option->update($request->validated());
            
            return response()->json([
                'message' => '修理の種類が正常に更新されました',
                'data' => $option,
                'success' => true
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => '修理の種類が見つかりません',
                'success' => false
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '修理の種類の更新に失敗しました: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}

