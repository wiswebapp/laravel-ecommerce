<?php

namespace App\Exports;

use App\Http\Controllers\admin\FilterController;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralExport extends FilterController implements FromCollection, WithHeadings
{
    // Define Export Type
    public $exportType;
    // Illuminate\Http\Request
    public $request;

    public function __construct($request)
    {
        $this->exportType = $request->get('exportType');
        $this->request = $request;
    }

    public function collection() {
        $data = [];

        if ($this->exportType == "user") {
            $fields = ['fname', 'lname', 'email', 'phonecode', 'phone', 'country', 'state', 'status','created_at'];

            $query = User::with(['getUserCountry', 'getUserState'])->select($fields)->whereNull('deleted_at')->orderBy('id', 'desc');
            $query = $this->filterUserData($this->request, $query);
            $data = $query->get();

            $data->map(function($mapData) {
                $mapData->country = $mapData->getUserCountry->name;
                $mapData->state = $mapData->getUserState->name;
                $mapData->created_at = $mapData->created_at->format('d-m-Y');
            });

            return $data;
        }
    }

    public function headings(): array
    {
        if ($this->exportType == "user") {
            return [
                'First Name',
                'Last Name',
                'Email Address',
                "PhoneCode",
                "Mobile Number",
                "Country",
                "State",
                "Status",
                "Registered On",
            ];
        }
    }
}
