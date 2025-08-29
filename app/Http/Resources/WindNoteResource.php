<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WindNoteResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
            'created_at' => $this->created_at->timezone('Asia/Tokyo')->toIso8601String(),
            'is_favorited' => $this->is_favorited > 0,
            'favorites_count' => $this->favorites_count,
            'favorites' => NoteFavoriteResource::collection($this->whenLoaded('noteFavorites')),
        ];
    }
}
