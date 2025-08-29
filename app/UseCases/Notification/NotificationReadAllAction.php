<?php

namespace App\UseCases\Notification;

use App\Http\Requests\Notification\NotificationReadAllRequest;
use App\Http\Resources\Common\SuccessResource;
use Illuminate\Support\Facades\Auth;

class NotificationReadAllAction
{
    public function __invoke(NotificationReadAllRequest $request)
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        $notifications->markAsRead();

        return new SuccessResource('通知を全て既読にしました');
    }
}