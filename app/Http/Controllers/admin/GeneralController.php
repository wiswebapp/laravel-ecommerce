<?php

namespace App\Http\Controllers\admin;

use App\Models\Store;
use App\Models\State;
use App\Models\Country;
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

        $storeData = Store::with(['getProducts'])
                        ->where(['status' => 'Active',])
                        ->whereNotNull('store_timing')
                        ->where('image','!=','');

        if($args['getPagination']) {
            $storeData = $storeData->paginate();
        } else {
            $storeData = $storeData->get();
        }

        return $storeData->reject(function ($store) {
            if( count($store->getProducts) > 0) {
                foreach($store->getProducts as $product) {
                    return $product->status != "Active";
                }
            }

            return true;
        });
    }

}
