<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class ProductController extends Controller
// {
//     public $school = "Mindoro State University";
//     public function index()
//     {
//         $student = "Bren";
//         $message = "Welcome to Laravel, $student!";
//         return response()->json([
//             'student' => $student,
//             'message' => $message,
//         ]);
//     }

//     public function read()
//     {
//         $message = "Welcome to Laravel!,  . $this->school";
//         return response()->json([
//             'school' => $this->school,
//             'message' => $message,
//         ]);
//     }

//     public function greet($name)
//     {
//         $message = "Hello, welcome to Laravel!, $name";
//         return response()->json([
//             'name' => $name,
//             'message' => $message,
//         ]);
//     }
// }


namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // INDEX
    public function index()
    {
        $numbers = [];

        for ($i = 1; $i <= 5; $i++) {
            $numbers[] = $i;
        }
        $products = Product::all();

        $result = [];

        foreach ($products as $product) {
            $result[] = [
                'id' => $product->id,
                'name' => $this->formatProductName($product->name),
                'slug' => $product->slug,
                'category' => $product->category,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'status' => $product->status,
            ];
        }

        return response()->json([
            'status' => true,
            'numbers' => $numbers,
            'data' => $result
        ], 200);
    }


    // SHOW USING SLUG
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully.',
            'data' => [
                'id' => $product->id,
                'name' => $this->formatProductName($product->name),
                'slug' => $product->slug,
                'category' => $product->category,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'status' => $product->status,
            ]
        ], 200);
    }


    // USER-DEFINED FUNCTION
    private function formatProductName($name)
    {
        return ucwords(
            strtolower(
                trim($name)
            )
        );
    }
}
