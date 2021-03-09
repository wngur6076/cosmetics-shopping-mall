<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/products",
     *      operationId="indexProduct",
     *      tags={"상품 관련"},
     *      summary="모든 상품 목록 가져오기",
     *      description="모든 상품 목록을 가져온다.",
     *      @OA\Parameter(
     *          name="page",
     *          description="페이지 번호",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          description="페이지 수 (기본: 20)",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="정렬이름 (기본: created_at)",
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"view_count", "created_at", "price", "review_grade"},
     *             )
     *         )
     *      ),
     *      @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="정렬주문 (기본: desc)",
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"desc", "asc"},
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공"
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *    )
     */
    public function index()
    {
        $query = new Product;
        $products = $query->orderBy(request('sort', 'created_at'), request('order', 'desc'))
            ->Paginate(request('per_page', 20));
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::find($id);

        return response()->json(new ProductResource($product), 200);
    }
}
