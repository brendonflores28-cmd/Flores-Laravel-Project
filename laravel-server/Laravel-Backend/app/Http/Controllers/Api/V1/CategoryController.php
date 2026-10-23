<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponses;

class CategoryController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $categories = Category::paginate(10);

        return $this->ok('Categories retrieved successfully', $categories);
    }

    public function show(Category $category)
    {
        return $this->ok('Category retrieved successfully', $category);
    }
}
