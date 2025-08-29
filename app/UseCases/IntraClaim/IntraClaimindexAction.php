<?php

namespace App\UseCases\IntraClaim;

use App\Http\Requests\IntraClaim\IntraClaimindexRequest;
use App\Http\Resources\IntraClaimResource;
use App\Models\IntraClaim;
use Illuminate\Support\Facades\Auth;

class IntraClaimindexAction
{
    public function __invoke(IntraClaimindexRequest $request)
    {
        $userId = Auth::id();

        $intraClaims = IntraClaim::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhere('intra_user_id', $userId);
        })->with(['departure', 'user.userProfile', 'intraUser.userProfile'])->get();

        return response()->json(IntraClaimResource::collection($intraClaims));
    }
}
