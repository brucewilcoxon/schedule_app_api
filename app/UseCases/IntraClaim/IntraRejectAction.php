<?php

namespace App\UseCases\IntraClaim;

use App\Http\Requests\IntraClaim\IntraRejectRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\IntraClaim;
use App\Models\User;
use App\Notifications\IntraClaimNotification;

class IntraRejectAction
{
    public function __invoke(IntraClaim $intraClaim, IntraRejectRequest $request)
    {
        // ログインユーザ(イントラを依頼されたユーザ)
        $intraUser = User::find($request->user()->id);
        $intraUserName = $intraUser->userProfile->name;

        // イントラを依頼したユーザ
        $departureUser = User::find($intraClaim->user_id);

        if ($intraUser->id !== $intraClaim->intra_user_id) {
            return response()->json([
                'message' => '依頼取り下げる権限がありません',
            ], 403);
        }

        $comment = "{$intraUserName}さんがイントラ依頼を取り下げました";

        // intraClaimのstatusを更新
        $intraClaim->update(['status' => 'reject']);

        $departureUser->notify(new IntraClaimNotification($intraClaim, $comment));

        return new SuccessResource('イントラ依頼を取り下げました');
    }
}
