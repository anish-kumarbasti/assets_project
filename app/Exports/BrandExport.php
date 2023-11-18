<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BrandExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Brand Name']
        ]);
    }
}
