<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'gender' => $this->gender ?? null,
            'age' => $this->age ?? null,
            'introduction' => $this->introduction ?? null,
            'profile_image' => $this->profile_image ?? null,
        ];    
    }
}
