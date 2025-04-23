<?php

use App\Http\Controllers\admin\ProductController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::prefix('products')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('listProducts');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
});
