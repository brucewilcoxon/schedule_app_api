<?php

use Illuminate\Support\Facades\Log;

// 基本的なエラー設定
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // リクエスト情報を記録
    $requestData = [
        'uri' => $_SERVER['REQUEST_URI'] ?? 'no uri',
        'method' => $_SERVER['REQUEST_METHOD'] ?? 'no method',
        'headers' => function_exists('getallheaders') ? getallheaders() : [],
        'time' => date('Y-m-d H:i:s'),
    ];
    
    error_log(json_encode([
        'level' => 'info',
        'message' => 'Incoming request',
        'context' => $requestData
    ]));

    require __DIR__.'/../public/index.php';

} catch (\Throwable $e) {
    // エラー情報を構造化
    $errorData = [
        'level' => 'error',
        'message' => $e->getMessage(),
        'context' => [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'code' => $e->getCode(),
            'trace' => explode("\n", $e->getTraceAsString()),
            'request' => [
                'uri' => $_SERVER['REQUEST_URI'] ?? 'no uri',
                'method' => $_SERVER['REQUEST_METHOD'] ?? 'no method',
                'headers' => function_exists('getallheaders') ? getallheaders() : [],
            ],
            'previous' => $e->getPrevious() ? [
                'message' => $e->getPrevious()->getMessage(),
                'file' => $e->getPrevious()->getFile(),
                'line' => $e->getPrevious()->getLine()
            ] : null
        ]
    ];

    // JSONとしてログ出力
    error_log(json_encode($errorData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    // クライアントへのレスポンス
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Internal Server Error',
        'debug' => $errorData['context']
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}