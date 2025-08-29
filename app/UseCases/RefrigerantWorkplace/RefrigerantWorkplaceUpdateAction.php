<?php

namespace App\UseCases\RefrigerantWorkplace;

use App\Http\Requests\RefrigerantWorkplace\RefrigerantWorkplaceUpdateRequest;
use App\Http\Resources\RefrigerantWorkplaceResource;
use App\Models\RefrigerantWorkplace;

class RefrigerantWorkplaceUpdateAction
{
    public function __invoke(RefrigerantWorkplaceUpdateRequest $request, $id)
    {
        $item = RefrigerantWorkplace::findOrFail($id);
        $item->update($request->validated());
        return new RefrigerantWorkplaceResource($item);
    }
}