<?php

namespace App\UseCases\Notification;

use App\Http\Requests\Notification\NotificationIndexRequest;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Auth;

class NotificationIndexAction
{
    public function __invoke(NotificationIndexRequest $request)
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $notifications = $user->notifications ?? collect([]);

            return response()->json(NotificationResource::collection($notifications));
        } catch (\Exception $e) {
            \Log::error('NotificationIndexAction error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }
}
