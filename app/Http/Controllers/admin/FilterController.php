<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FilterController extends GeneralController
{
    public function filterUserData(Request $request, $query){
        //Filter With Name
        if (!empty($request->input('name'))) {
            $query->where('fname', 'LIKE', '%' . $request->input('name') . '%');
            $query->orWhere('lname', 'LIKE', '%' . $request->input('name') . '%');
        }
        //Filter With Status
        if (!empty($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }

        return $query;
    }
}
