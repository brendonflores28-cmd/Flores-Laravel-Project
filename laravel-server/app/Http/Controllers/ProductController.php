<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $school = "Mindoro State University";
    public function index()
    {
        $student = "Bren";
        $message = "Welcome to Laravel, $student!";
        return response()->json([
            'student' => $student,
            'message' => $message,
        ]);
    }

    public function read()
    {
        $message = "Welcome to Laravel!,  . $this->school";
        return response()->json([
            'school' => $this->school,
            'message' => $message,
        ]);
    }

    public function greet($name)
    {
        $message = "Hello, welcome to Laravel!, $name";
        return response()->json([
            'name' => $name,
            'message' => $message,
        ]);
    }
}
