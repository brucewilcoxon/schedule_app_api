<?php

namespace App\UseCases\RefrigerantWorkplace;

use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceStoreRequest;
use App\Http\Resources\RefrigerantWorkplaceResource;
use App\Models\RefrigerantWorkplace;

class RefrigerantWorkplaceStoreAction
{
    public function __invoke(RefrigerantWorkplaceStoreRequest $request)
    {
        $item = RefrigerantWorkplace::create($request->validated());
        return new RefrigerantWorkplaceResource($item);
    }
}