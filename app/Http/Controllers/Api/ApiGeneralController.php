<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\admin\FilterController;

class ApiGeneralController extends FilterController
{
    public function returnResponse($data, $success = true){
        return [
            'success' => $success,
            'data' => $data,
            'version' => '1.0',
            'date' => date('d-m-Y h:i:s'),
        ];
    }
}
