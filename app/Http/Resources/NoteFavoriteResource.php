<?php

namespace App\Http\Resources;

use App\Models\WindNote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteFavoriteResource extends JsonResource
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
            'note' => new WindNoteResource($this->whenLoaded('note'))
      ];    
    }
}
