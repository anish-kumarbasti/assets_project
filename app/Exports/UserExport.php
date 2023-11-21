<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]);
    }
    public function headings(): array
    {
        return [
            'Employee ID',
            'Employee Name',
            'Email',
            'Mobile Number',
            'Age',
            'Gender',
            'Password',
            'Department ID',
            'Department Name',
            'Designation',
            'Location',
            'Sub Location',
            'Role',
        ];
    }
}
