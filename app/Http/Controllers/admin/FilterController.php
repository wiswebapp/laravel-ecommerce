<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use App\Models\Banner;
use Illuminate\Http\Request;

class FilterController extends GeneralController {

    public function filterAdminData(Request $request, $getAllData = false) {
        $query = Admin::orderBy('id', 'desc');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            $selectedIds = $request->input('selectedIds');
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if (! empty($request->input('name'))) {
                $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if (! empty($request->input('status'))) {
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }

    public function filterUserData(Request $request, $getAllData = false) {
        $query = User::whereNull('deleted_at')->orderBy('id', 'desc');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            $selectedIds = $request->input('selectedIds');
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if (! empty($request->input('name'))) {
                $query->where('fname', 'LIKE', '%' . $request->input('name') . '%');
                $query->orWhere('lname', 'LIKE', '%' . $request->input('name') . '%');
            }

            if (! empty($request->input('status'))) {
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }

    public function filterCategoryData(Request $request, $getAllData = false) {
        $query = Category::whereNull(['parent_id', 'deleted_at'])->orderBy('id', 'desc');
        $selectedIds = $request->input('selectedIds');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if(! empty($request->input('name'))){
                $query->where('category_name','LIKE','%'. $request->input('name') .'%');
            }

            if(! empty($request->input('status'))){
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }

    public function filterSubCategoryData(Request $request, $getAllData = false) {
        $query = Category::whereNull('deleted_at')->whereNotNull('parent_id')->orderBy('id', 'desc');
        $selectedIds = $request->input('selectedIds');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if(!empty($request->input('name'))){
                $query->where('category_name','LIKE','%'. $request->input('name').'%');
            }

            if(!empty($request->input('status'))){
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }

    public function filterProductData(Request $request, $getAllData = false) {
        $query = Product::whereNull('deleted_at')->orderBy('id', 'desc');
        $selectedIds = $request->input('selectedIds');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if(!empty($request->input('store'))){
                $query->where('store_id', $request->input('store'));
            }

            if(!empty($request->input('name'))){
                $query->where('product_name','LIKE','%'. $request->input('name').'%');
            }

            if(!empty($request->input('status'))){
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }

    public function filterStoreData(Request $request, $getAllData = false) {
        $query = Store::whereNull('deleted_at')->orderBy('id', 'desc');
        $selectedIds = $request->input('selectedIds');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if(!empty($request->input('name'))){
                $query->where('name','LIKE','%'. $request->input('name').'%');
            }

            if(!empty($request->input('status'))){
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }

    public function filterBannerData(Request $request, $getAllData = false) {
        $query = Banner::orderBy('order', 'asc');
        $selectedIds = $request->input('selectedIds');
        //Filter Only if get all data is not selected
        if (! $getAllData) {
            if (! empty($request->input('selectedIds'))) {
                $query->whereIn('id', explode(',', $selectedIds));
            }

            if(! empty($request->input('name'))){
                $query->where('title','LIKE','%'. $request->input('name') .'%');
            }

            if(! empty($request->input('status'))){
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }
}
