<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartureResource extends JsonResource
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
            'start' => $this->start->timezone('Asia/Tokyo')->toIso8601String(),
            'end' => $this->end->timezone('Asia/Tokyo')->toIso8601String(),
            'description' => $this->description,
            'user' => new UserResource($this->whenLoaded('user')),
            'intraUser' => new UserResource($this->whenLoaded('intraUser'))
        ];
    }
}
