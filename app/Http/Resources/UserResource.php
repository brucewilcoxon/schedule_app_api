<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'email' => $this->email,
            'role' => $this->role ?? 'worker',
            'user_profile' => $this->whenLoaded('userProfile') && $this->userProfile
                ? new UserProfileResource($this->userProfile)
                : null,
        ];

        // Log safely without trying to serialize the resource
        \Log::info('UserResource data:', [
            'id' => $data['id'],
            'email' => $data['email'],
            'role' => $data['role'],
            'has_profile' => $data['user_profile'] !== null,
        ]);

        return $data;
    }
}
