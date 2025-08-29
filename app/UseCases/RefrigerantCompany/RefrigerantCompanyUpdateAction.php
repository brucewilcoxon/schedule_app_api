<?php

namespace App\UseCases\RefrigerantCompany;

use App\Http\Requests\RefrigerantCompany\RefrigerantCompanyUpdateRequest;
use App\Http\Resources\RefrigerantCompanyResource;
use App\Models\RefrigerantCompany;

class RefrigerantCompanyUpdateAction
{
    public function __invoke(RefrigerantCompanyUpdateRequest $request, $id)
    {
        $company = RefrigerantCompany::findOrFail($id);
        $company->update($request->validated());
        
        return new RefrigerantCompanyResource($company);
    }
} 