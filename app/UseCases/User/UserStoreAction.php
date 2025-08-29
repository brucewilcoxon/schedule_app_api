<?php

namespace App\UseCases\User;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserStoreAction
{
    public function __invoke(UserStoreRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'role' => $request->role ?? 'worker',
            'password' => Hash::make($request->password),
        ]);

        // Create or update user profile
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $request->name,
                'gender' => $request->gender,
                'age' => $request->age,
                'introduction' => $request->introduction,
            ]
        );

        $user->load('userProfile');

        return response()->json(new UserResource($user), 201);
    }
} 