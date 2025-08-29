<?php

namespace App\UseCases\User;

use App\Http\Requests\User\UserIndexRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserGradeFilterAction
{
    public function __invoke(UserIndexRequest $request)
    {
        try {
            $users = User::with('userProfile')
                ->whereHas('userProfile', function ($query) {
                    $query->whereBetween('age', ['20', '40']);
                })
                ->get();

            return response()->json(UserResource::collection($users));
        } catch (\Exception $e) {
            Log::error('Error in UserGradeFilterAction: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to filter users by grade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}