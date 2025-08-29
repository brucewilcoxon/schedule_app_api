<?php

namespace App\UseCases\RefrigerantCompany;

use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyDeleteRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\RefrigerantCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class RefrigerantCompanyDeleteAction
{
    public function __invoke(RefrigerantCompanyDeleteRequest $request, $id): JsonResponse
    {
        try {
            $company = RefrigerantCompany::findOrFail($id);
            $company->delete();
            
            return response()->json([
                'message' => '冷媒会社が正常に削除されました',
                'success' => true
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => '冷媒会社が見つかりません',
                'success' => false
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '冷媒会社の削除に失敗しました: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
} 