<?php

namespace App\UseCases\User;

use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\User;
use App\Models\UserProfile;

class UserDeleteAction
{
    public function __invoke(UserDeleteRequest $request, $id)
    {
        \Log::info('UserDeleteAction called with ID:', ['id' => $id]);
        
        try {
            $user = User::findOrFail($id);
            \Log::info('User found:', ['user_id' => $user->id, 'email' => $user->email]);
            
            // Prevent users from deleting themselves
            if ($request->user() && $request->user()->id === $user->id) {
                \Log::warning('User attempted to delete themselves:', ['user_id' => $user->id]);
                return response()->json(['message' => '自分自身を削除することはできません'], 400);
            }
            
            // Prevent deleting the last manager
            if ($user->role === 'manager') {
                $managerCount = User::where('role', 'manager')->count();
                if ($managerCount <= 1) {
                    \Log::warning('Attempted to delete the last manager:', ['user_id' => $user->id]);
                    return response()->json(['message' => '最後の管理者を削除することはできません'], 400);
                }
            }
            
            // Delete all related records first
            // Delete user profile
            $profileDeleted = UserProfile::where('user_id', $user->id)->delete();
            \Log::info('User profile deleted:', ['deleted_count' => $profileDeleted]);
            
            // Delete questions
            $questionsDeleted = $user->questions()->delete();
            \Log::info('Questions deleted:', ['deleted_count' => $questionsDeleted]);
            
            // Delete answers
            $answersDeleted = $user->answers()->delete();
            \Log::info('Answers deleted:', ['deleted_count' => $answersDeleted]);
            
            // Delete wind notes
            $windNotesDeleted = $user->windNotes()->delete();
            \Log::info('Wind notes deleted:', ['deleted_count' => $windNotesDeleted]);
            
            // Delete calendar events
            $calendarEventsDeleted = $user->calendarEvents()->delete();
            \Log::info('Calendar events deleted:', ['deleted_count' => $calendarEventsDeleted]);
            
            // Delete notifications (polymorphic relationship)
            $notificationsDeleted = $user->notifications()->delete();
            \Log::info('Notifications deleted:', ['deleted_count' => $notificationsDeleted]);
            
            // Delete note favorites
            $noteFavoritesDeleted = $user->notefavorites()->delete();
            \Log::info('Note favorites deleted:', ['deleted_count' => $noteFavoritesDeleted]);
            
            // Delete departures (these have cascade, but let's be explicit)
            $departuresDeleted = $user->departures()->delete();
            \Log::info('Departures deleted:', ['deleted_count' => $departuresDeleted]);
            
            // Delete intra departures
            $intraDeparturesDeleted = $user->intraDepartures()->delete();
            \Log::info('Intra departures deleted:', ['deleted_count' => $intraDeparturesDeleted]);
            
            // Delete claims
            $claimsDeleted = $user->claims()->delete();
            \Log::info('Claims deleted:', ['deleted_count' => $claimsDeleted]);
            
            // Delete intra claims
            $intraClaimsDeleted = $user->intraClaims()->delete();
            \Log::info('Intra claims deleted:', ['deleted_count' => $intraClaimsDeleted]);
            
            // Delete the user
            $userDeleted = $user->delete();
            \Log::info('User deleted:', ['deleted' => $userDeleted]);

            return new SuccessResource('ユーザーを削除しました');
        } catch (\Exception $e) {
            \Log::error('UserDeleteAction error:', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
} 