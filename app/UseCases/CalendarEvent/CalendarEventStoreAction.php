<?php

namespace App\UseCases\CalendarEvent;

use App\Http\Requests\CalendarEvent\CalendarEventStoreRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\CalendarEvent;
use App\Models\User;
use App\Notifications\CalendarEventNotification;

class CalendarEventStoreAction
{
    public function __invoke(CalendarEventStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $calendarEvent = CalendarEvent::create($validated);

        // Notify all users about the created calendar event
        $users = User::all();
        foreach ($users as $notifiableUser) {
            $notifiableUser->notify(new CalendarEventNotification($calendarEvent, 'calendar_created'));
        }

        return new SuccessResource('カレンダーイベントの作成に成功しました');
    }
}
