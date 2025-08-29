<?php

namespace App\UseCases\RefrigerantCompany;

use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyIndexRequest;
use App\Http\Resources\RefrigerantCompanyResource;
use App\Models\RefrigerantCompany;

class RefrigerantCompanyIndexAction
{
    public function __invoke(RefrigerantCompanyIndexRequest $request)
    {
        $companies = RefrigerantCompany::with('manager')->orderBy('created_at', 'desc')->get();
        
        return RefrigerantCompanyResource::collection($companies);
    }
} 