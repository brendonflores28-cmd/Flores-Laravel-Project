<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HRCalculatorController;
use App\Http\Controllers\ProductController;

Route::post('/payroll/calculate', [HRCalculatorController::class, 'calculate']);
Route::apiResource('products', ProductController::class); 