<?php

namespace App\UseCases\CalendarEvent;

use App\Http\Requests\CalendarEvent\CalendarEventUpdateRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\CalendarEvent;

class CalendarEventUpdateAction
{
    public function __invoke(CalendarEventUpdateRequest $request, CalendarEvent $calendarEvent)
    {
        $validated = $request->validated();

        if ($request->user()->id !== $calendarEvent->user_id) {
            return response()->json([
                'message' => 'イベントの編集をする権限がありません'
            ], 403);
        }

        $calendarEvent->update($validated);

        return new SuccessResource('カレンダーイベントの更新に成功しました');
    }
}
