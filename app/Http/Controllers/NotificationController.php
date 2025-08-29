<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\NotificationIndexRequest;
use App\Http\Requests\Notification\NotificationReadAllRequest;
use App\UseCases\Notification\NotificationIndexAction;
use App\UseCases\Notification\NotificationReadAction;
use App\UseCases\Notification\NotificationReadAllAction;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(NotificationIndexRequest $request, NotificationIndexAction $action)
    {
        return $action($request);
    }

    public function read(NotificationReadAction $action, DatabaseNotification $notification)
    {
        return $action($notification);
    }

    public function readAll(NotificationReadAllRequest $request, NotificationReadAllAction $action)
    {
        return $action($request);
    }
}
