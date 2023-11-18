<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class AttributeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Asset Type','Attribute Name']
        ]);
    }
}
