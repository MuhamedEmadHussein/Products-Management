<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\App\Http\Controllers\Api\V1\CategoryController;
use Modules\Products\App\Http\Controllers\Api\V1\ProductController;

Route::prefix('v1')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
});