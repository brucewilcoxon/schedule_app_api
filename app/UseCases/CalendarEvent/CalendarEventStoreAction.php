<?php

namespace App\UseCases\CalendarEvent;

use App\Http\Requests\CalendarEvent\CalendarEventStoreRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\CalendarEvent;

class CalendarEventStoreAction
{
    public function __invoke(CalendarEventStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;


        $calendarEvent = CalendarEvent::create($validated);

        return new SuccessResource('カレンダーイベントの作成に成功しました');
    }
}
