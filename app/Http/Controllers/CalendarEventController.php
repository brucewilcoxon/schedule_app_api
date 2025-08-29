<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarEvent\CalendarEventDeleteRequest;
use App\Http\Requests\CalendarEvent\CalendarEventIndexRequest;
use App\Http\Requests\CalendarEvent\CalendarEventStoreRequest;
use App\Http\Requests\CalendarEvent\CalendarEventUpdateRequest;
use App\Models\CalendarEvent;
use App\Models\WindNote;
use App\UseCases\CalendarEvent\CalendarEventDeleteAction;
use App\UseCases\CalendarEvent\CalendarEventIndexAction;
use App\UseCases\CalendarEvent\CalendarEventStoreAction;
use App\UseCases\CalendarEvent\CalendarEventUpdateAction;

class CalendarEventController extends Controller
{
    public function index(CalendarEventIndexRequest $request, CalendarEventIndexAction $action)
    {
        return $action($request);
    }

    public function store(CalendarEventStoreRequest $request, CalendarEventStoreAction $action)
    {
        return $action($request);
    }

    public function update(CalendarEventUpdateRequest $request, CalendarEvent $calendarEvent, CalendarEventUpdateAction $action)
    {
        return $action($request, $calendarEvent);
    }

    public function destroy(CalendarEvent $calendarEvent, CalendarEventDeleteAction $action)
    {
        return $action($calendarEvent);
    }
}
