<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// public routes

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// protected route

Route::middleware(['auth' => 'api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);
});
