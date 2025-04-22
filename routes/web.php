<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',       [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',      [AuthController::class, 'login'])->name('login.post');

Route::post('/logout',         [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes (Static UI only)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
Route::get('/reset-password', [AuthController::class, 'showResetForm']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
