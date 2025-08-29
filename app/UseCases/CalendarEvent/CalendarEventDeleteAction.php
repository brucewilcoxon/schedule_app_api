<?php

namespace App\UseCases\CalendarEvent;

use App\Http\Requests\CalendarEvent\CalendarEventDeleteRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;

class CalendarEventDeleteAction
{
    public function __invoke(CalendarEvent $calendarEvent)
    {
        $user = Auth::user();

        if ($user->id !== $calendarEvent->user_id) {
            return response()->json([
                'message' => '削除する権限がありません',
            ], 403);
        }

        $calendarEvent->delete();

        return new SuccessResource('カレンダーイベントの削除に成功しました');
    }
}
