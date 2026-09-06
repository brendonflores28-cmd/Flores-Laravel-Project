<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HRCalculatorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Ecommerce\AuthController;
use App\Http\Controllers\Ecommerce\CategoryController;
use App\Http\Controllers\Ecommerce\OrderController;
use App\Http\Controllers\Ecommerce\ProductController as EcommerceProductController;

Route::post('/payroll/calculate', [HRCalculatorController::class, 'calculate']);
Route::apiResource('products', ProductController::class);

// --- E-commerce API (JWT auth) ---
Route::prefix('ecommerce')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/products', [EcommerceProductController::class, 'index']);
    Route::get('/products/{product}', [EcommerceProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::apiResource('products', EcommerceProductController::class)->except(['index', 'show']);
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
    });
});
