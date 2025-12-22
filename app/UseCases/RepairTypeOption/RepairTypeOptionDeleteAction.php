<?php

namespace App\UseCases\RepairTypeOption;

use App\Http\Requests\RepairTypeOption\RepairTypeOptionDeleteRequest;
use App\Models\RepairTypeOption;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class RepairTypeOptionDeleteAction
{
    public function __invoke(RepairTypeOptionDeleteRequest $request, $id): JsonResponse
    {
        try {
            $option = RepairTypeOption::findOrFail($id);
            $option->delete();
            
            return response()->json([
                'message' => '修理の種類が正常に削除されました',
                'success' => true
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => '修理の種類が見つかりません',
                'success' => false
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '修理の種類の削除に失敗しました: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}

