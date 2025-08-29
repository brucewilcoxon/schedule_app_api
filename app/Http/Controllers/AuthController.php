<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\UserProfile;
use App\UseCases\Auth\LoginAction;
use App\UseCases\Auth\RegisterAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // ユーザー登録
    public function register(RegisterRequest $request, RegisterAction $action)
    {
        return $action($request);
    }

    // ログイン
    public function login(LoginRequest $request, LoginAction $action)
    {
        return $action($request);
    }

    // ログアウト
    public function logout(Request $request)
    {
        // Delete all Sanctum tokens for the authenticated user
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Clear all relevant cookies with proper settings
        $cookies = [
            cookie()->forget('XSRF-TOKEN'),
            cookie()->forget(config('session.cookie')),
            cookie()->forget('laravel_session'),
            cookie()->forget('windap_session'),
            cookie()->forget('remember_web'),
            cookie()->forget('remember_token'),
        ];

        $response = response()->json([
            'message' => 'ログアウトしました',
            'success' => true
        ], Response::HTTP_OK);

        // Apply all cookie deletions with different path and domain combinations
        foreach ($cookies as $cookie) {
            $response->withCookie($cookie);
            
            // Also clear with different paths
            $response->withCookie(cookie()->forget($cookie->getName(), '/api'));
            $response->withCookie(cookie()->forget($cookie->getName(), '/sanctum'));
        }

        // Clear session data
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $response;
    }
}
