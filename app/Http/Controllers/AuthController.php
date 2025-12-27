<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\UseCases\Auth\LoginAction;
use App\UseCases\Auth\RegisterAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        // Support both Bearer token and session-based auth
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }

        // Get session domain from config or use .mrservice.jp as default for cross-subdomain support
        $sessionDomain = config('session.domain');
        if (empty($sessionDomain)) {
            // Extract root domain from request host (e.g., api.mrservice.jp -> .mrservice.jp)
            $host = $request->getHost();
            if (preg_match('/\.([^.]+\.(?:jp|com|net|org))$/', $host, $matches)) {
                $sessionDomain = '.' . $matches[1];
            } else {
                $sessionDomain = null;
            }
        } else {
            // Ensure domain starts with dot for subdomain sharing
            if (substr($sessionDomain, 0, 1) !== '.') {
                $sessionDomain = '.' . $sessionDomain;
            }
        }

        // Clear all relevant cookies with proper domain settings
        $cookieNames = [
            'XSRF-TOKEN',
            config('session.cookie'),
            'laravel_session',
            'windap_session',
            'remember_web',
            'remember_token',
        ];

        $response = response()->json([
            'message' => 'ログアウトしました',
            'success' => true,
        ], Response::HTTP_OK);

        // Clear cookies with different path and domain combinations
        $paths = ['/', '/api', '/sanctum'];
        foreach ($cookieNames as $cookieName) {
            if (empty($cookieName)) {
                continue;
            }
            
            foreach ($paths as $path) {
                // Clear without domain
                $response->withCookie(cookie()->forget($cookieName, $path));
                
                // Clear with session domain if available
                if ($sessionDomain) {
                    $response->withCookie(
                        cookie()->forget($cookieName, $path)
                            ->domain($sessionDomain)
                    );
                }
            }
        }

        // Clear session data
        if ($request->hasSession()) {
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return $response;
    }
}
