<?php

namespace App\UseCases\Departure;

use App\Http\Resources\Common\SuccessResource;
use App\Models\Departure;
use Illuminate\Support\Facades\Auth;

class DepartureDeleteAction
{
    public function __invoke(Departure $departure)
    {
        $user = Auth::user();

        if ($user->id !== $departure->user_id) {
            return response()->json([
                'message' => '削除する権限がありません',
            ], 403);
        }

        $departure->delete();

        return new SuccessResource('出艇の削除に成功しました');
    }
}