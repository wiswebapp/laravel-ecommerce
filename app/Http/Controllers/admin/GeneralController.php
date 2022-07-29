<?php

namespace App\Http\Controllers\admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GeneralClass;

class GeneralController extends Controller
{
    use GeneralClass;

    public function getCountry() {
        return Country::all()->sortBy('name');
    }

}
