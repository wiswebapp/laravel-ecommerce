<?php

namespace App\Http\Controllers\admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MyClass\GeneralClass;
use App\State;
use App\Exports\GeneralExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GeneralController extends Controller
{
    use GeneralClass;

    public function getCountry() {
        return Country::all()->sortBy('name');
    }

    public function getState() {
        $country = (int)$_POST['countryId'];
        $selectedState = (int)$_POST['selectedState'];
        $data = State::where('country_id', $country)->get()->toArray();
        $optionHtml = "<option>Select State</option>";
        foreach ($data as $state){
            $selected = ($selectedState == $state['id']) ? "selected" : "";
            $optionHtml .=  "<option  ".$selected." value='".$state['id']."'>".$state['name']."</option>";
        }

        return $optionHtml;
    }

    /**
     *
     * This Functions used for export data
     * all the module export functionality function should be define here
     * use same format define in existing functions
     *
     * @param  Request $request
     * @return Excel
     */
    public function user_export(Request $request) {
        $fileName = "users_".date("YmdHI").".xlsx";
        return Excel::download(new GeneralExport($request), $fileName);
    }
}
