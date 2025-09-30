<?php

namespace App\UseCases\CalendarEvent;

use App\Http\Requests\CalendarEvent\CalendarEventDeleteRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CalendarEventNotification;

class CalendarEventDeleteAction
{
    public function __invoke(CalendarEvent $calendarEvent)
    {
        $user = Auth::user();

        // Allow managers to delete any event, or allow users to delete their own events
        if (!$user->isManager() && $user->id !== $calendarEvent->user_id) {
            return response()->json([
                'message' => '削除する権限がありません',
            ], 403);
        }

        // Notify all users about the deleted calendar event
        $users = User::all();
        foreach ($users as $notifiableUser) {
            $notifiableUser->notify(new CalendarEventNotification($calendarEvent, 'calendar_deleted'));
        }

        $calendarEvent->delete();

        return new SuccessResource('カレンダーイベントの削除に成功しました');
    }
}
