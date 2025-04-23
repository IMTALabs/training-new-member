<?php


use App\Http\Controllers\Admin\ProductController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;




Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::prefix('products')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('listProducts');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/login',       [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',      [AuthController::class, 'login'])->name('login.post');
Route::get('/register',    [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register',   [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',     [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
  Route::get('/', function () {
        return 'chao mung den trang qtri';
    });
  Route::get('/dashboard',          [DashboardController::class, 'index'])->name('dashboard');
  Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/',             [CategoryController::class, 'index'])->name('index');
    Route::get('/create',       [CategoryController::class, 'create'])->name('create');
    Route::post('/',            [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit',    [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}',         [CategoryController::class, 'update'])->name('update');
    });
  Route::prefix('products') ->middleware(['auth'])->name('products.')->group(function () { 
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');
    });
});
