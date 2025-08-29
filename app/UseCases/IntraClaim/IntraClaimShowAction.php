<?php

namespace App\UseCases\IntraClaim;

use App\Http\Requests\IntraClaim\IntraClaimShowRequest;
use App\Http\Resources\IntraClaimResource;
use App\Models\IntraClaim;

class IntraClaimShowAction
{
    public function __invoke(IntraClaim $intraClaim ,IntraClaimShowRequest $request)
    {
        $intraClaim->load(['departure', 'user.userProfile', 'intraUser.userProfile']);
        return response()->json(new IntraClaimResource(($intraClaim)));
    }
}