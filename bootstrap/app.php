<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Redirect guest (belum login / session habis) sesuai path yang diakses
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            return route('petugas.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tangani token CSRF expired (419) -> redirect ke login sesuai guard
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, Request $request) {
            $guard = ($request->is('admin') || $request->is('admin/*')) ? 'admin' : 'petugas';

            return redirect()
                ->route($guard . '.login')
                ->with('error', 'Sesi Anda telah berakhir, silakan login kembali.');
        });
    })->create();