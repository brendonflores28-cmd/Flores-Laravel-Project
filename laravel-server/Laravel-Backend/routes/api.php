<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HRCalculatorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\V1\CategoryController as V1CategoryController;
use App\Http\Controllers\Api\V1\ProductController as V1ProductController;

Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/payroll/calculate', [HRCalculatorController::class, 'calculate']);
Route::apiResource('products', ProductController::class)->names('legacy.products');

Route::prefix('v1')->group(function () {
    Route::get('/products/queries', [V1ProductController::class, 'queries']);
    Route::apiResource('products', V1ProductController::class)->only(['index', 'show']);
    Route::get('/categories/{category}', [V1CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories', [V1CategoryController::class, 'index'])->name('categories.index');
});
