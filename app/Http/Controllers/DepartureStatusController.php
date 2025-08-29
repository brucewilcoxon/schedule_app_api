<?php

namespace App\Http\Controllers;

use App\Http\Requests\Departure\DepartureStatusRequest;
use App\UseCases\Departure\DepartureStatusAction;
use Illuminate\Http\Request;

class DepartureStatusController extends Controller
{
    public function index(DepartureStatusRequest $request, DepartureStatusAction $action)
    {
        return $action($request);
    }
}
