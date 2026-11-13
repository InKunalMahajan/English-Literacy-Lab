<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tenant authorization will be registered only after its policies and tests exist.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Keep the default Laravel exception handler in the foundation sprint.
    })->create();
