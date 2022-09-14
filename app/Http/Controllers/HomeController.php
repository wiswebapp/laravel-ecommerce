<?php
namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $data['bannerData'] = Banner::where('status', 'Active')->orderBy('order','asc')->get();
        $data['storeData'] = Store::where('status', 'Active')->orderBy('id','desc')->take(6)->get();
        $data['categoryList'] = Category::where('parent_id', 0)->orderBy('id','desc')->take(10)->get();
        $data['productList'] = Product::orderBy('id','desc')->take(10)->get();

        return view('index')->with('data',$data);
    }
}
