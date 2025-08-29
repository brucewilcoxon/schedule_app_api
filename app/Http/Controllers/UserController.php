<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserDeleteRequest;
use App\UseCases\User\UserGradeFilterAction;
use App\UseCases\User\UserIndexAction;
use App\UseCases\User\UserStoreAction;
use App\UseCases\User\UserUpdateAction;
use App\UseCases\User\UserDeleteAction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserIndexRequest $request, UserIndexAction $action)
    {
        return $action($request);
    }

    public function gradeFilter(UserIndexRequest $request, UserGradeFilterAction $action)
    {
        return $action($request);
    }

    public function store(UserStoreRequest $request, UserStoreAction $action)
    {
        return $action($request);
    }

    public function update(UserUpdateRequest $request, UserUpdateAction $action, $id)
    {
        return $action($request, $id);
    }

    public function destroy(UserDeleteRequest $request, UserDeleteAction $action, $id)
    {
        return $action($request, $id);
    }
}
