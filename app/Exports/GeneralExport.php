<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralExport implements FromCollection, WithHeadings
{

    public function __construct($dataArray, $headingArray) {
        $this->exportData = $dataArray;
        $this->headingsData = $headingArray;
    }

    public function collection()
    {
        return $this->exportData;
    }

    public function headings(): array
    {
        return $this->headingsData;
    }
}
