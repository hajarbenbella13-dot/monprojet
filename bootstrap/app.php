<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Zid l-Middleware dyal l-CORS li creeyiti
        $middleware->append(\App\Http\Middleware\Cors::class);

        // 2. 7eyed l-CSRF 3la l-API bach Flutter i-9der i-sift POST
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();