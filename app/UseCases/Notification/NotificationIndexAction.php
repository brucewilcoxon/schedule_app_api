<?php

namespace App\UseCases\Notification;

use App\Http\Requests\Notification\NotificationIndexRequest;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;

class NotificationIndexAction
{
   public function __invoke(NotificationIndexRequest $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        return response()->json(NotificationResource::collection($notifications));
    }
}