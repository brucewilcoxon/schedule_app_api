<?php

namespace App\UseCases\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterAction
{
    public function __invoke(RegisterRequest $request)
    {
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            throw ValidationException::withMessages([
                'email' => ['このメールアドレスは既に使用されています。'],
            ]);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create a default user profile
        UserProfile::create([
            'user_id' => $user->id,
            'name' => null,
            'gender' => null,
            'age' => null,
            'introduction' => null,
            'profile_image' => null,
        ]);

        return new SuccessResource('ユーザ新規登録に成功しました');
    }
}