<?php

namespace App\macro;

use DB;
use App\Category;

class QueryFunctionMacros{


    public function getCategoryData(){

        return function ($fieldName='*', $where = ['status'=>'Active'], $orderBy='id', $desc = 'desc')
        {
            $query = Category::select($fieldName);
            $query->where($where);
            $query->whereNull(['deleted_at', 'parent_id']);
            $data = $query->orderBy($orderBy, $desc)->get();

            return $data;
        };
    }
    public function getSubCategoryData(){

        return  function ($fieldName='*', $where = ['status'=>'Active'], $orderBy='id', $desc = 'desc')
        {
            return Category::select($fieldName)
                        ->where($where)
                        ->whereNotNull('parent_id')
                        ->whereNull('deleted_at')
                        ->orderBy($orderBy, $desc)
                        ->get();
        };
    }
}
