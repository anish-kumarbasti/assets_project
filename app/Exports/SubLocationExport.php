<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SubLocationExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Location Name', 'Sub Location Name'],
        ]);
    }
}
