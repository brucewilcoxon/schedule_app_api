<?php

namespace App\UseCases\UserProfile;

use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;

class UserProfileIndexAction
{
    public function __invoke(): JsonResponse
    {
        $userProfiles = UserProfile::select('id', 'name')->orderBy('name')->get();
        
        return response()->json([
            'data' => $userProfiles
        ]);
    }
}