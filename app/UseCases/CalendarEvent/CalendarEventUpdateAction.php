<?php

namespace App\UseCases\CalendarEvent;

use App\Http\Requests\CalendarEvent\CalendarEventUpdateRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\CalendarEvent;
use App\Models\User;
use App\Notifications\CalendarEventNotification;

class CalendarEventUpdateAction
{
    public function __invoke(CalendarEventUpdateRequest $request, CalendarEvent $calendarEvent)
    {
        $validated = $request->validated();
        $user = $request->user();

        // Allow managers to edit any event, or allow users to edit their own events
        if (!$user->isManager() && $user->id !== $calendarEvent->user_id) {
            return response()->json([
                'message' => 'イベントの編集をする権限がありません'
            ], 403);
        }

        $calendarEvent->update($validated);

        // Notify all users about the updated calendar event
        $users = User::all();
        foreach ($users as $notifiableUser) {
            $notifiableUser->notify(new CalendarEventNotification($calendarEvent, 'calendar_updated'));
        }

        return new SuccessResource('カレンダーイベントの更新に成功しました');
    }
}
