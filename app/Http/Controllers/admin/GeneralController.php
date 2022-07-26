<?php

namespace App\Http\Controllers\admin;

use App\User;
use App\State;
use App\Country;
use Illuminate\Http\Request;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GeneralClass;

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
    **/
    public function user_export(Request $request) {
        $exportType = $request->get('exportType');
        $fileName = "users_".date("YmdHI").".xlsx";
        $filterClass = new FilterController();

        if ($exportType == "user") {
            $fields = ['fname', 'lname', 'email', 'phonecode', 'phone', 'country', 'state', 'status','created_at'];
            $query = User::with(['getUserCountry', 'getUserState'])->select($fields)->whereNull('deleted_at')->orderBy('id', 'desc');
            $query = $filterClass->filterUserData($request, $query);
            $data = $query->get();

            $data->map(function($mapData) {
                $mapData->country = $mapData->getUserCountry->name;
                $mapData->state = $mapData->getUserState->name;
                $mapData->created_at = $mapData->created_at->format('d-m-Y');
            });

            $requestData = $data;
            $requestHeading =  [ 'First Name', 'Last Name', 'Email Address', "PhoneCode", "Mobile Number", "Country", "State", "Status", "Registered On" ];
        }

        return Excel::download(new GeneralExport($requestData, $requestHeading), $fileName);
    }
}
