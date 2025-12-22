<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepairTypeOption\RepairTypeOptionDeleteRequest;
use App\Http\Requests\RepairTypeOption\RepairTypeOptionIndexRequest;
use App\Http\Requests\RepairTypeOption\RepairTypeOptionStoreRequest;
use App\Http\Requests\RepairTypeOption\RepairTypeOptionUpdateRequest;
use App\UseCases\RepairTypeOption\RepairTypeOptionDeleteAction;
use App\UseCases\RepairTypeOption\RepairTypeOptionIndexAction;
use App\UseCases\RepairTypeOption\RepairTypeOptionStoreAction;
use App\UseCases\RepairTypeOption\RepairTypeOptionUpdateAction;

class RepairTypeOptionController extends Controller
{
    public function index(RepairTypeOptionIndexRequest $request, RepairTypeOptionIndexAction $action)
    {
        return $action($request);
    }

    public function store(RepairTypeOptionStoreRequest $request, RepairTypeOptionStoreAction $action)
    {
        return $action($request);
    }

    public function update(RepairTypeOptionUpdateRequest $request, RepairTypeOptionUpdateAction $action, $id)
    {
        return $action($request, $id);
    }

    public function destroy(RepairTypeOptionDeleteRequest $request, RepairTypeOptionDeleteAction $action, $id)
    {
        return $action($request, $id);
    }
}
