<?php

namespace App\UseCases\User;

use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserUpdateAction
{
    public function __invoke(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        
        $userData = [
            'email' => $request->email,
        ];

        if ($request->filled('role')) {
            $userData['role'] = $request->role;
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

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

        return response()->json(new UserResource($user));
    }
} 