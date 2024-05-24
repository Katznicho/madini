<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function getProductsByPage(Request $request)
    {
        try {
            // Get request parameters with default values
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $sortOrder = $request->input('sort_order', 'desc');
            $categoryId = $request->input('category_id',1);
    
            // Validate the category_id
            if (!in_array($categoryId, [1, 2, 3, 4])) {
                return response()->json(['success' => false, 'message' => 'Invalid category_id.']);
            }
    
            // Fetch and paginate products based on the category_id
            $products = Product::where("category_id", $categoryId)
                ->orderBy('id', $sortOrder)
                ->paginate($limit, ['*'], 'page', $page);
    
            // Prepare the response
            $response = [
                'data' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'per_page' => $limit,
                    'total' => $products->total(),
                ],
            ];
    
            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
