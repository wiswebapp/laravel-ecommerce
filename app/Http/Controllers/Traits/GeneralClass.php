<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait GeneralClass
{
    public $dayArray = [
        'Sun' => 'Sunday',
        'Mon' => 'Monday',
        'Tue' => 'Tuesday',
        'Wed' => 'Wednesday',
        'Thu' => 'Thursday',
        'Fri' => 'Friday',
        'Sat' => 'Saturday'
    ];

    public function renderResponse($pageTitle, $otherParamertes = []) {
        $responseData = [];
        $responseData['pageTitle'] = $pageTitle;
        if (! empty($otherParamertes)) {
            foreach ($otherParamertes as $key => $value) {
                $responseData[$key] = $value;
            }
        }

        return $responseData;
    }

    public function get_admin_path() {

        return [
            'admin_path' => config('app.admin_path_name')
        ];
    }

    public function get_ajax_data(Request $request) {
        $table = $request->input('tableName');
        $tableId = $request->input('tableId');

        $data = DB::table($table)->where(['id' => $tableId])->get();

        return $data;
    }
}
