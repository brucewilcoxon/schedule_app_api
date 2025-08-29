<?php

namespace App\UseCases\WindNote;

use App\Http\Requests\WindNote\WindNoteIndexRequest;
use App\Http\Resources\WindNoteResource;
use App\Models\WindNote;

class WindNoteIndexAction
{
    public function __invoke(WindNoteIndexRequest $request)
    {
        $userId = $request->query('user_id');
        $user = $request->user();

        $query = WindNote::with(['user.userProfile', 'noteFavorites.user.userProfile'])
            ->withCount(['noteFavorites as favorites_count'])
            ->withCount(['noteFavorites as is_favorited' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $windNotes = $query->orderBy('created_at', 'desc')->get();

        return response()->json(WindNoteResource::collection($windNotes));
    }
}
