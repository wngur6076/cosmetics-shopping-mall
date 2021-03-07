<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    public function show($id)
    {
        $product = Product::find($id);

        return response()->json(new ProductResource($product), 200);
    }
}
