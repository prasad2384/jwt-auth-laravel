<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function ($e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof TokenInvalidException) {
                    return response()->json(['error' =>
                    'Token is invalid'], 401);
                } else if ($e instanceof TokenExpiredException) {
                    return response()->json(['error' =>
                    'Token is expired'], 401);
                } else if ($e instanceof JWTException) {
                    return response()->json(['error' =>
                    'Authorization Token not found'], 401);
                } else if ($e instanceof AuthenticationException) {
                    return response()->json(['error' =>
                    'Unauthenticated'], 401);
                }

                // Handle other exceptions or provide a default response
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        });
    })->create();
