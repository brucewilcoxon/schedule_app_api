<?php

namespace App\UseCases\RefrigerantCompany;

use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyStoreRequest;
use App\Http\Resources\RefrigerantCompanyResource;
use App\Models\RefrigerantCompany;

class RefrigerantCompanyStoreAction
{
    public function __invoke(RefrigerantCompanyStoreRequest $request)
    {
        $company = RefrigerantCompany::create($request->validated());
        
        return new RefrigerantCompanyResource($company);
    }
} 