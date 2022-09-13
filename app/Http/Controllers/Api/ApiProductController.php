<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends ApiGeneralController
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => [
            'index', 'show'
        ]]);
    }

    public function index(Request $request)
    {
        $productListing = $this->filterProductData($request);

        return $this->returnResponse([
            'message' => "Product Listing Success",
            'productDetail' => $productListing->paginate(10),
        ]);
    }

    public function show($id)
    {
        $success = false;
        $message = "No Product Data Founded !";
        $product = Product::find($id);

        if($product) {
            $success = true;
            $message = "Product Founded !";
        }

        return $this->returnResponse([
            'message' => $message,
            'productDetail' => $product,
        ], $success);
    }
}
