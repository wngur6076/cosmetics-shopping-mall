<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __invoke()
    {
        $categories = Category::whereNull('category_id')->with('categories')->get();

        return response()->json($categories, 200);
    }
}
