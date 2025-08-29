<?php

namespace App\UseCases;

use App\Http\Requests\UserProfileStoreRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class UserProfileStoreAction
{
    public function __invoke(UserProfileStoreRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();
        
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return new SuccessResource('プロフィールを登録しました');
    }
}