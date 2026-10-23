<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/variable-scope', [ProductController::class, 'index']);
Route::get('/variable-school', [ProductController::class, 'read']);
Route::get('/global-variable', [ProductController::class, 'read']);
Route::get('/greet/{name}', [ProductController::class, 'greet']);
