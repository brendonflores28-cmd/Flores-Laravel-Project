<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ecommerce\StoreProductRequest;
use App\Models\Ecommerce\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category');

        if ($category = $request->query('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        return response()->json($query->paginate(15));
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('category'));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json($product->load('category'), 201);
    }

    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json($product->load('category'));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
