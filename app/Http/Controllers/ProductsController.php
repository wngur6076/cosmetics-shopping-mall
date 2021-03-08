<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    public function index()
    {
        $query = new Product;
        $products = $query->orderBy(request('sort', 'created_at'), request('order', 'desc'))
            ->Paginate(request('per_page', 20));
        return ProductResource::collection($products)
            ->additional(['products_count' => Product::count()]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        return response()->json(new ProductResource($product), 200);
    }
}
