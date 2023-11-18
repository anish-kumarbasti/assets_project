<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SupplierExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Supplier Id', 'Supplier Name', 'Email', 'Phone-No.', 'Address'],
        ]);
    }
}
