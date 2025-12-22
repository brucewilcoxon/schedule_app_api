<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Prefer human-friendly type saved in data['type'] when present
        $data = $this->data ?? [];
        $displayType = is_array($data) && array_key_exists('type', $data)
            ? $data['type']
            : ($this->type ?? 'notification');

        return [
            'id' => $this->id,
            'type' => $displayType,
            'notifiable_id' => $this->notifiable_id,
            'notifiable_type' => $this->notifiable_type,
            'data' => $data,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
        ];
    }
}
