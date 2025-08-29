<?php

namespace App\UseCases\WindNote;

use App\Models\NoteFavorite;
use App\Models\WindNote;
use Illuminate\Support\Facades\Auth;

class NoteFavoriteShowAction
{
    public function __invoke(WindNote $windNote)
    {
        $user = Auth::user();

        $favorite = NoteFavorite::where('note_id', $windNote->id)
            ->where('user_id', $user->id)
            ->first();

        return response()->json($favorite);
    }
}
