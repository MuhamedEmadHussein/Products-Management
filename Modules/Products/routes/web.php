<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\App\Http\Controllers\CategoryController;
    
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/{id}', [CategoryController::class, 'edit'])->name('edit');
});
