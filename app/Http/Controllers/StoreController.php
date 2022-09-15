<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\admin\GeneralController;

class StoreController extends GeneralController
{
    public function storeListing(Request $request){

        if ($request->method() == "POST") {
            $osmUrl = 'https://nominatim.openstreetmap.org/reverse?format=json&lat='. $lat .'&lon='. $long .'&zoom=18&addressdetails=1';
            /*
                Address Example
                https://nominatim.openstreetmap.org/reverse?format=json&lat=23.0225&lon=72.5714&zoom=18&addressdetails=1
            */
            $res = Http::get($osmUrl);
            $response = $res->json();

            Session::put([
                'userStoreLat' => $request->userStoreLat,
                'userStoreLong' => $request->userStoreLong,
                'userStoreAddress' => $request->userStoreAddress,
                'userStoreAddressDetail' => $response['address'],
            ]);

            return redirect('store-listing');
        }

        $userStore = Session::get('userStoreAddressDetail');
        $location = [
            'lat' => Session::get('userStoreLat'),
            'long' => Session::get('userStoreLong')
        ];

        $add['state'] = empty($userStore['state']) ? $userStore['state_district'] : $userStore['state'];
        $add['city'] = empty($userStore['city']) ? $userStore['building'] : $userStore['city'];
        $add['suburb'] = empty($userStore['suburb']) ? $userStore['road'] : $userStore['suburb'];
        $add['neighbour'] = empty($userStore['neighbourhood']) ? $userStore['state_district'] : $userStore['neighbourhood'];
        $data['shownAddress'] = implode(', ', array_filter($add));
        $data['storeData'] = $this->getstoreData($location, [
            'getPagination' => true
        ]);

        return view('store_listing')->with('data',$data);
    }
}
