<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        // APIリクエストの場合
        if ($request->expectsJson()) {
            $response = [
                'status' => 'error',
                'error' => [
                    'code' => 500,
                    'message' => 'データの取得中にエラーが発生しました。',
                    'details' => [
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                    ]
                ]
            ];
            // 開発環境の場合はスタックトレースを追加
            if (config('app.debug')) {
                $response['error']['details']['trace'] = $exception->getTraceAsString();
            }
            return response()->json($response, 500);
        }
        return parent::render($request, $exception);
    }
}
