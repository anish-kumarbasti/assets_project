<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ReasonExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Reason Name']
        ]);
    }
}
