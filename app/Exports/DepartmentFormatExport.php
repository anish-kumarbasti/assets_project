<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class DepartmentFormatExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Department Name', 'Department ID'],
        ]);
    }
}
