<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\App\Http\Controllers\CategoryController;
use Modules\Products\App\Http\Controllers\ProductController;

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/{id}', [CategoryController::class, 'edit'])->name('edit');
});

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/{id}', [ProductController::class, 'edit'])->name('edit');
});