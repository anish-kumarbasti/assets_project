<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class MaintenanceSupplier implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['Maintenance Supplier Id', 'Maintenance Supplier Name', 'Email', 'Phone-No.', 'Address'],
        ]);
    }
}
