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
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'agent' => \App\Http\Middleware\AgentMiddleware::class,
            'client' => \App\Http\Middleware\ClientMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'session.cookie' => \App\Http\Middleware\SetSessionCookie::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
