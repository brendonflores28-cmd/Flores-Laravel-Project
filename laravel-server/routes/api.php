<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function () {
    return response()->json([
        'message' => 'My first Laravel API',
        'products' => [
            [
                'id' => 1,
                'name' => 'Laptop',
                'price' => 145000
            ],
            [
                'id' => 2,
                'name' => 'Mouse',
                'price' => 1000
            ],
            [
                'id' => 3,
                'name' => 'Keyboard',
                'price' => 1500
            ]
        ]
    ]);
});