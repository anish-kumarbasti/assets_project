<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class AssetExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Asset Type','Asset Name']
        ]);
    }
}
