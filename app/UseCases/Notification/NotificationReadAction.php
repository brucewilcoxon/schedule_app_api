<?php

namespace App\UseCases\Notification;

use App\Http\Resources\Common\SuccessResource;
use Illuminate\Notifications\DatabaseNotification;

class NotificationReadAction
{
    public function __invoke(DatabaseNotification $notification)
    {
        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        return new SuccessResource('通知を既読にしました');
    }
}