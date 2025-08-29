<?php

namespace App\UseCases\Departure;

use App\Http\Resources\DepartureResource;
use App\Models\Departure;

class DepartureShowAction
{
    public function __invoke(Departure $departure)
    {
        $departure->load(['intraUser', 'user']);
        return response()->json(new DepartureResource($departure));
    }
}