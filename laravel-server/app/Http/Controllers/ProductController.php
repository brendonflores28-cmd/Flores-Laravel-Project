<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $student = "PJ";
        $message = "Welcome to Laravel, $student!";
        return response()->json([
            'student' => $student,
            'message' => $message,
        ]);
    }
}
