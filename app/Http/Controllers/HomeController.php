<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $data['categoryList'] = Category::where('parent_id',0)->orderBy('id', 'desc')->take(10)->get();
        $data['productList'] = Product::orderBy('id','desc')->take(10)->get();

        return view('index')->with('data',$data);
    }
}
