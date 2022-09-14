<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        $data['userCount'] = User::all()->whereNull('deleted_at')->count();
        $data['productCount'] = Product::all()->whereNull('deleted_at')->count();
        $data['categoryCount'] = Category::all()->where('parent_id',0)->whereNull('deleted_at')->count();
        $data['subCategoryCount'] = Category::all()->where('parent_id','!=',0)->whereNull('deleted_at')->count();
        return view('admin.dashboard')->with('data',$data);
    }

    public function getUserData()
    {
        $data = [];
        if(! $this->checkPermission('View User')) {
            return $data;
        }

        $data = User::select(['fname', 'lname', 'created_at'])->limit(8)->orderBy('created_at', 'desc')->get();
        $data->map(function ($user) {
            $user->registered_on = $user->created_at->toDateString();
        });

        return $data;
    }

    public function getStoreData(Request $request)
    {
        $data = [];
        if(! $this->checkPermission('View Store')) {
            return $data;
        }

        $data = Store::where('id', $request->storeId)->first();

        return $data;
    }

    public function getStoresData()
    {
        $data = [];
        if(! $this->checkPermission('View Store')) {
            return $data;
        }

        $data = Store::select(['id', 'owner', 'name', 'created_at', 'email', 'image', 'status'])->limit(4)->orderBy('id', 'desc')->get();
        if (! empty($data)) {
            $data->map(function ($user) {
                $user->registered_on = $user->created_at->toDateString();
            });
        }

        return $data;
    }
}
