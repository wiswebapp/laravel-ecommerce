<?php

namespace App\Http\Controllers\admin;

use App\User;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class FilterController extends GeneralController {

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

            if(!empty($request->input('name'))){
                $query->where('product_name','LIKE','%'. $request->input('name').'%');
            }

            if(!empty($request->input('status'))){
                $query->where('status', $request->input('status'));
            }
        }

        return $query;
    }
}
