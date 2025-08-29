<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartureStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'notified' => $this->formatNotifiedAbsentees($this->resource['notified']),
            'no_notification' => UserResource::collection($this->resource['no_notification']),
        ];
    }

    private function formatNotifiedAbsentees($notifiedAbsentees)
    {
        return collect($notifiedAbsentees)->map(function ($item) {
            return [
                'user' => new UserResource($item['user']),
                'events' => CalendarEventResource::collection($item['events']),
            ];
        });
    }
}
