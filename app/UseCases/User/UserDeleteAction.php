<?php

namespace App\UseCases\User;

use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\User;
use App\Models\UserProfile;

class UserDeleteAction
{
    public function __invoke(UserDeleteRequest $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Delete related user profile first
        UserProfile::where('user_id', $user->id)->delete();
        
        // Delete the user
        $user->delete();

        return new SuccessResource('ユーザーを削除しました');
    }
} 