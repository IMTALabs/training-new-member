<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',       [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',      [AuthController::class, 'login'])->name('login.post');

Route::post('/logout',         [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
