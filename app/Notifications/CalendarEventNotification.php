<?php

namespace App\Notifications;

use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CalendarEventNotification extends Notification
{
    use Queueable;

    protected CalendarEvent $calendarEvent;
    protected string $type;

    public function __construct(CalendarEvent $calendarEvent, string $type)
    {
        $this->calendarEvent = $calendarEvent;
        $this->type = $type; // 'calendar_created' | 'calendar_updated' | 'calendar_deleted'
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Ensure relations for richer payloads if needed
        $this->calendarEvent->load('user.userProfile');

        return [
            'type' => $this->type,
            'calendar' => [
                'id' => $this->calendarEvent->id,
                'vehicle_info' => $this->calendarEvent->vehicle_info,
                'repair_type' => $this->calendarEvent->repair_type,
                'start' => $this->calendarEvent->start,
                'end' => $this->calendarEvent->end,
                'status' => $this->calendarEvent->status,
                'workers' => $this->calendarEvent->workers,
                'user' => [
                    'id' => $this->calendarEvent->user?->id,
                    'name' => $this->calendarEvent->user?->userProfile?->name,
                ],
            ],
        ];
    }
} 