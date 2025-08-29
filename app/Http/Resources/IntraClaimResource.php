<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntraClaimResource extends JsonResource
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
            'status' => $this->status,
            'departure' => new DepartureResource($this->whenLoaded('departure')),
            'user' => new UserResource($this->whenLoaded('user')),
            'intra_user' => new UserResource($this->whenLoaded('intraUser'))
      ];
    }
}
