<?php

namespace App\UseCases\Departure;

use App\Http\Requests\Departure\DepartureRankingRequest;
use App\Http\Resources\DepartureRankingResource;
use App\Models\Departure;

class DepartureRankingAction
{
    public function __invoke(DepartureRankingRequest $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        // 年と月でフィルタし、ユーザーごとに出発回数をカウント
        $departures = Departure::with('user.userProfile')
            ->when($year, fn($query) => $query->whereYear('start', $year))
            ->when($month, fn($query) => $query->whereMonth('start', $month))
            ->selectRaw('user_id, COUNT(*) as departures_count')
            ->groupBy('user_id')
            ->orderByDesc('departures_count')
            ->get();
        

        return response()->json(DepartureRankingResource::collection($departures));
    }
}