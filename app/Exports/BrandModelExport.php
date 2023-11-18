<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BrandModelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Brand Name', 'Model Name'],
        ]);
    }
}
