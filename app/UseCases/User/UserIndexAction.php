<?php

namespace App\UseCases\User;

use App\Http\Requests\User\UserIndexRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserIndexAction
{
    public function __invoke(UserIndexRequest $request)
    {
        try {
            $users = User::with('userProfile')->get();
            
            // Filter out users that might cause issues
            $validUsers = $users->filter(function ($user) {
                return $user->id && $user->email;
            });
            
            return response()->json(UserResource::collection($validUsers));
        } catch (\Exception $e) {
            Log::error('Error in UserIndexAction: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to retrieve users',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}