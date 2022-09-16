<?php

namespace App\Http\Controllers\admin;

use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GeneralClass;

class GeneralController extends Controller
{
    use GeneralClass;

    public $uploadPath;

    public function __construct() {

        $pathArr = [];
        $imageFolder = ['banner', 'product', 'store'];

        foreach($imageFolder as $value) {
            $pathArr[$value] = '/public/' . $value . '/';
            $pathArr[$value . "_public"] = public_path('storage/' . $value . '/');
            $pathArr[$value . "_storage"] = storage_path($value . '/');
        }

        $this->uploadPath = $pathArr;
    }

    public function generateFileName($suffix = '', $extension = '') {
        $suffix = (! empty($suffix)) ? $suffix.'_' : '';
        $extension = (! empty($extension)) ? '.' . $extension : '';
        $fileName =  $suffix . time() . $extension;

        return $fileName;
    }

    public function getCountry() {
        return Country::all()->sortBy('name');
    }

    public function getState() {
        $country = (int)$_POST['countryId'];
        $selectedState = (int)$_POST['selectedState'];
        $data = State::where('country_id', $country)->get()->toArray();
        $optionHtml = "<option value=''>Select State</option>";
        foreach ($data as $state){
            $selected = ($selectedState == $state['id']) ? "selected" : "";
            $optionHtml .=  "<option  ".$selected." value='".$state['id']."'>".$state['name']."</option>";
        }

        return $optionHtml;
    }

    public function getstoreData($location, $args = []) {
        $lat = $location['lat'];
        $long = $location['long'];

        $storeData = DB::table('stores')
                        ->select('stores.*')
                        ->join('products', 'stores.id', '=', 'products.store_id')
                        ->where([
                            'stores.status' => 'Active',
                            'products.status' => 'Active',
                        ])
                        ->whereNotNull('stores.store_timing')
                        ->where('stores.image','!=','');

        if($args['getPagination']) {
            $storeData = $storeData->paginate(10);
        } else {
            $storeData = $storeData->get();
        }

        return $storeData;
    }

}
