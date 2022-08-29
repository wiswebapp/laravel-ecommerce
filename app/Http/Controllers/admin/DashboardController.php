<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Store;

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

    public function getStoreData()
    {
        $data = [];
        if(! $this->checkPermission('View Store')) {
            return $data;
        }

        $data = Store::select(['owner', 'name', 'created_at', 'email', 'image'])->where('status', 'Active')->limit(4)->orderBy('id', 'desc')->get();
        if (! empty($data)) {
            $data->map(function ($user) {
                $user->registered_on = $user->created_at->toDateString();
            });
        }

        return $data;
    }
}
