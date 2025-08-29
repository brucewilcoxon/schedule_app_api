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
            'user_profile' => $this->whenLoaded('userProfile') ? new UserProfileResource($this->userProfile) : null
        ];
        
        \Log::info('UserResource data:', $data);
        
        return $data;
    }
}
