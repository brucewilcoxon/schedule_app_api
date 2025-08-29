<?php

namespace App\UseCases\WindNote;

use App\Http\Requests\WindNote\WindNoteShowRequest;
use App\Http\Resources\WindNoteResource;
use App\Models\WindNote;

class WindNoteShowAction
{
    public function __invoke(WindNoteShowRequest $request, WindNote $windNote)
    {
        $user = $request->user();

        $windNote = WindNote::with(['user.userProfile', 'noteFavorites.user.userProfile'])
            ->withCount(['noteFavorites as favorites_count'])
            ->withCount(['noteFavorites as is_favorited' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->findOrFail($windNote->id);

        return response()->json(new WindNoteResource($windNote));
    }
}
