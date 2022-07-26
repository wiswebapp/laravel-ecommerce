<?php

namespace App\Http\Controllers\Traits;

trait GeneralClass
{
    public function get_admin_path() {

        return [
            'admin_path' => config('app.admin_path_name')
        ];
    }

    public function filterData($filterType, $request, $query) {
        switch ($filterType) {
            case 'Admin':
                if (!empty($request->name)) {
                    $query->where('name', 'LIKE', '%' . $request->name . '%');
                }
                if (!empty($request->status)) {
                    $query->where('status', $request->status);
                }
                break;
        }
        return $query;
    }
}
