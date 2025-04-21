<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return 'Hello, World!';
});

// Password Reset Routes (Static UI only)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
Route::get('/reset-password', [AuthController::class, 'showResetForm']);
