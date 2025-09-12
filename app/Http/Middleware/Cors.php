<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Allow your frontend domain only or use '*' for all origins (not recommended for production)
        $response->headers->set('Access-Control-Allow-Origin', 'https://mrservice.jp');
        
        // Allowed HTTP methods
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        
        // Allowed headers
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        
        // Allow credentials if needed
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        // Handle preflight requests
        if ($request->getMethod() === "OPTIONS") {
            $response->setStatusCode(204);
            return $response;
        }

        return $response;
    }
}
