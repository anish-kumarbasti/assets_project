<?php

namespace App\Exports;

use App\Models\Designation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DesignationExport implements FromCollection
{
    public function collection()
    {
        return collect([
            ['Department Name', 'Designation Name'],
        ]);
    }
}
