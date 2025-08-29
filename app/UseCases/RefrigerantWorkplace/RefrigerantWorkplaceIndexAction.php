<?php

namespace App\UseCases\RefrigerantWorkplace;

use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceIndexRequest;
use App\Http\Resources\RefrigerantWorkplaceResource;
use App\Models\RefrigerantWorkplace;

class RefrigerantWorkplaceIndexAction
{
    public function __invoke(RefrigerantWorkplaceIndexRequest $request)
    {
        $items = RefrigerantWorkplace::orderBy('created_at', 'desc')->get();
        return RefrigerantWorkplaceResource::collection($items);
    }
}