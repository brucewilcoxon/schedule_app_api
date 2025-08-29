<?php

namespace App\Http\Controllers;

use App\Http\Requests\Departure\DepartureRankingRequest;
use App\Http\Resources\DepartureRankingResource;
use App\Models\Departure;
use App\UseCases\Departure\DepartureRankingAction;
use Illuminate\Http\Request;

class DepartureRankingController extends Controller
{
    public function index(DepartureRankingRequest $request, DepartureRankingAction $action)
    {
        return $action($request);
    }
}
