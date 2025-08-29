<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyIndexRequest;
use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyStoreRequest;
use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyUpdateRequest;
use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyDeleteRequest;
use App\UseCases\RefrigerantCompany\RefrigerantCompanyIndexAction;
use App\UseCases\RefrigerantCompany\RefrigerantCompanyStoreAction;
use App\UseCases\RefrigerantCompany\RefrigerantCompanyUpdateAction;
use App\UseCases\RefrigerantCompany\RefrigerantCompanyDeleteAction;

class RefrigerantCompanyController extends Controller
{
    public function index(RefrigerantCompanyIndexRequest $request, RefrigerantCompanyIndexAction $action)
    {
        return $action($request);
    }

    public function store(RefrigerantCompanyStoreRequest $request, RefrigerantCompanyStoreAction $action)
    {
        return $action($request);
    }

    public function update(RefrigerantCompanyUpdateRequest $request, RefrigerantCompanyUpdateAction $action, $id)
    {
        return $action($request, $id);
    }

    public function destroy(RefrigerantCompanyDeleteRequest $request, RefrigerantCompanyDeleteAction $action, $id)
    {
        return $action($request, $id);
    }
} 