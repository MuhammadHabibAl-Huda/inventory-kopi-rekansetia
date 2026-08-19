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
    ->withMiddleware(function (Middleware $middleware): void {
        // Jika user belum login dan mencoba akses rute yang dilindungi,
        // arahkan ke halaman login
        $middleware->redirectGuestsTo('/login');

        // Daftarkan alias untuk middleware khusus Admin
        $middleware->alias([
            'admin.only' => \App\Http\Middleware\AdminOnly::class,
        ]);

        // Exclude API webhook dari CSRF verification
        // agar bisa dihit dari POS / Postman tanpa CSRF token
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        // Tambahkan CORS headers untuk semua response API
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
