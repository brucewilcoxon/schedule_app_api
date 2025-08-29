<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceIndexRequest;
use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceStoreRequest;
use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceUpdateRequest;
use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceDeleteRequest;
use App\UseCases\RefrigerantWorkplace\RefrigerantWorkplaceIndexAction;
use App\UseCases\RefrigerantWorkplace\RefrigerantWorkplaceStoreAction;
use App\UseCases\RefrigerantWorkplace\RefrigerantWorkplaceUpdateAction;
use App\UseCases\RefrigerantWorkplace\RefrigerantWorkplaceDeleteAction;

class RefrigerantWorkplaceController extends Controller
{
    public function index(RefrigerantWorkplaceIndexRequest $request, RefrigerantWorkplaceIndexAction $action)
    {
        return $action($request);
    }

    public function store(RefrigerantWorkplaceStoreRequest $request, RefrigerantWorkplaceStoreAction $action)
    {
        return $action($request);
    }

    public function update(RefrigerantWorkplaceUpdateRequest $request, RefrigerantWorkplaceUpdateAction $action, $id)
    {
        return $action($request, $id);
    }

    public function destroy(RefrigerantWorkplaceDeleteRequest $request, RefrigerantWorkplaceDeleteAction $action, $id)
    {
        return $action($request, $id);
    }
}
