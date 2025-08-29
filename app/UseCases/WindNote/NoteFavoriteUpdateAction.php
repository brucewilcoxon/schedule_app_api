<?php

namespace App\UseCases\WindNote;

use App\Http\Resources\Common\SuccessResource;
use App\Models\NoteFavorite;
use App\Models\WindNote;
use Illuminate\Support\Facades\Auth;

class NoteFavoriteUpdateAction
{
    public function __invoke(WindNote $windNote)
    {
        $user = Auth::user();

        $favorite = NoteFavorite::where('note_id', $windNote->id)
            ->where('user_id', $user->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'message' => 'いいねを解除しました',
                'data' => [
                    'favorite' => null
                ],
            ], 200);
        }

        $newFavorite = NoteFavorite::create([
            'user_id' => $user->id,
            'note_id' => $windNote->id
        ]);

        return new SuccessResource('ノートの更新に成功しました');
    }
}
