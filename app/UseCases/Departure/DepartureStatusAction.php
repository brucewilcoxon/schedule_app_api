<?php

namespace App\UseCases\Departure;

use App\Http\Requests\Departure\DepartureStatusRequest;
use App\Http\Resources\DepartureStatusResource;
use App\Models\User;
use Carbon\Carbon;

class DepartureStatusAction
{
    public function __invoke(DepartureStatusRequest $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->next(Carbon::FRIDAY);

        // 出艇がゼロのユーザーを取得
        $usersWithZeroDepartures = User::with(['userProfile', 'calendarEvents' => function ($query) use ($startOfWeek, $endOfWeek) {
            $query->where('is_absent', true)
                  ->whereBetween('start', [$startOfWeek, $endOfWeek]);
        }])->whereDoesntHave('departures', function ($query) use ($startOfWeek, $endOfWeek) {
            $query->whereBetween('start', [$startOfWeek, $endOfWeek]);
        })->get();

        // 結果を振り分け
        $notifiedAbsentees = [];
        $noNotificationAbsentees = [];
        foreach ($usersWithZeroDepartures as $user) {
            if ($user->calendarEvents->isNotEmpty()) {
                $notifiedAbsentees[] = [
                    'user' => $user,
                    'events' => $user->calendarEvents
                ];
            } else {
                $noNotificationAbsentees[] = $user;
            }
        }

        return response()->json(new DepartureStatusResource([
            'notified' => $notifiedAbsentees,
            'no_notification' => $noNotificationAbsentees,
        ]));
    }
}
