<?php

namespace App\Exports;

use App\Http\Controllers\admin\FilterController;

class GeneralExport extends FilterController
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
}
