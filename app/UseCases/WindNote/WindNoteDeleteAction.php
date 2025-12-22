<?php

namespace App\UseCases\WindNote;

use App\Http\Resources\Common\SuccessResource;
use App\Models\WindNote;
use Illuminate\Support\Facades\Auth;

class WindNoteDeleteAction
{
    public function __invoke(WindNote $windNote)
    {
        $user = Auth::user();

        // Allow managers to delete any note, or users to delete their own notes
        if (! $user->isManager() && $user->id !== $windNote->user_id) {
            return response()->json([
                'message' => '削除する権限がありません',
            ], 403);
        }

        $windNote->delete();

        return new SuccessResource('ノートの削除に成功しました');
    }
}
