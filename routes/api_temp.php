<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\DepartureController;
use App\Http\Controllers\DepartureRankingController;
use App\Http\Controllers\DepartureStatusController;
use App\Http\Controllers\IntraClaimController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NoteFavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RefrigerantCompanyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WindNoteController;
use App\Http\Controllers\RefrigerantWorkplaceController;
use App\Http\Resources\UserResource;
use App\Models\IntraClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 認証不要ルート
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/windNotes', [WindNoteController::class, 'index'])->name('windNote.index');
Route::get('/departures', [DepartureController::class, 'index'])->name('departures.index');
Route::get('/departures/rankings', [DepartureRankingController::class, 'index'])->name('departures.ranking');
Route::get('/departures/status', [DepartureStatusController::class, 'index'])->name('departures.status');
Route::get('/questions', [QuestionController::class, 'index'])->name('question.index');
Route::get('/calendars', [CalendarEventController::class, 'index'])->name('calendarEvent.index');
Route::get('/answers', [AnswerController::class, 'index'])->name('answer.index');
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

// 認証必要ルート
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user()->load('userProfile');

        \Log::info('API /user endpoint called:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'has_profile' => $user->userProfile ? 'yes' : 'no',
            'profile_data' => $user->userProfile
        ]);

        return response()->json(new UserResource($user));
    });
    Route::get('/profile', function (Request $request) {
        $user = $request->user()->load('userProfile');
        return response()->json($user->userProfile);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile', [UserProfileController::class, 'store'])->name('profile.update');
    Route::post('/profile/upload-image', [UserProfileController::class, 'uploadImage'])->name('profile.uploadImage');

    // User Management routes - restricted to managers only
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/gradeFilter', [UserController::class, 'gradeFilter'])->name('users.filters');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/windNote', [WindNoteController::class, 'store'])->name('windNote.store');
    Route::get('/windNote/{windNote}', [WindNoteController::class, 'show'])->name('windNote.show');
    Route::put('/windNote/{windNote}', [WindNoteController::class, 'update'])->name('windNote.update');
    Route::delete('/windNote/{windNote}', [WindNoteController::class, 'destroy'])->name('windNote.destroy');

    Route::post('/question', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question/{question}', [QuestionController::class, 'show'])->name('question.show');
    Route::put('/question/{question}', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');

    Route::post('/answer', [AnswerController::class, 'store'])->name('answer.store');
    Route::put('/answer/{answer}', [AnswerController::class, 'update'])->name('answer.update');
    Route::delete('/answer/{answer}', [AnswerController::class, 'destroy'])->name('answer.destroy');

    Route::post('/calendar', [CalendarEventController::class, 'store'])->name('calendarEvent.store');
    Route::put('/calendar/{calendarEvent}', [CalendarEventController::class, 'update'])->name('calendarEvent.update');
    Route::delete('/calendar/{calendarEvent}', [CalendarEventController::class, 'destroy'])->name('calendarEvent.destroy');

    Route::get('/windNote/{windNote}/favorite', [NoteFavoriteController::class, 'show'])->name('noteFavorite.show');
    Route::put('/windNote/{windNote}/favorite', [NoteFavoriteController::class, 'update'])->name('noteFavorite.update');

    Route::post('/departure', [DepartureController::class, 'store'])->name('departures.store');
    Route::get('/departure/{departure}', [DepartureController::class, 'show'])->name('departures.show');
    Route::put('/departure/{departure}', [DepartureController::class, 'update'])->name('departures.update');
    Route::delete('/departure/{departure}', [DepartureController::class, 'destroy'])->name('departures.destroy');

    // 出艇ランキング
    Route::post('/approveClaim/{intraClaim}', [IntraClaimController::class, 'approveClaim'])->name('intraClaim.approveClaim');
    Route::post('/rejectClaim/{intraClaim}', [IntraClaimController::class, 'rejectClaim'])->name('intraClaim.rejectClaim');
    Route::get('/intraClaims', [IntraClaimController::class, 'index'])->name('intraClaim.index');
    Route::get('/intraClaim/{intraClaim}', [IntraClaimController::class, 'show'])->name('intraClaim.show');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notification/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/notification/{notification}', [NotificationController::class, 'show'])->name('notification.show');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    // Refrigerant Company routes
    Route::get('/refrigerant-companies', [RefrigerantCompanyController::class, 'index'])->name('refrigerant-companies.index');
    Route::post('/refrigerant-companies', [RefrigerantCompanyController::class, 'store'])->name('refrigerant-companies.store');
    Route::put('/refrigerant-companies/{id}', [RefrigerantCompanyController::class, 'update'])->name('refrigerant-companies.update');
    Route::delete('/refrigerant-companies/{id}', [RefrigerantCompanyController::class, 'destroy'])->name('refrigerant-companies.destroy');

    // User Profile routes
    Route::get('/user-profiles', [UserProfileController::class, 'index'])->name('user-profiles.index');

    // Refrigerant Workplace routes
    Route::get('/refrigerant-workplaces', [RefrigerantWorkplaceController::class, 'index'])->name('refrigerant-workplaces.index');
    Route::post('/refrigerant-workplaces', [RefrigerantWorkplaceController::class, 'store'])->name('refrigerant-workplaces.store');
    Route::put('/refrigerant-workplaces/{id}', [RefrigerantWorkplaceController::class, 'update'])->name('refrigerant-workplaces.update');
    Route::delete('/refrigerant-workplaces/{id}', [RefrigerantWorkplaceController::class, 'destroy'])->name('refrigerant-workplaces.destroy');
    }); // Close the manager middleware group
}); // Close the auth:sanctum middleware group
?>