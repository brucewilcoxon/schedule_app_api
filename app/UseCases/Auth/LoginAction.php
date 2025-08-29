<?php

namespace App\UseCases\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginAction
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
        $user = Auth::user();
        
        // Load the user profile
        $user->load('userProfile');
        
        \Log::info('User data after login:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'has_profile' => $user->userProfile ? 'yes' : 'no',
            'profile_data' => $user->userProfile
        ]);
        
        // Create Sanctum token for API authentication
        $token = $user->createToken('auth-token')->plainTextToken;
        
        return response()->json([
            'message' => 'ログインに成功しました',
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }
}
