<?php

namespace App\Imports;

use App\Models\BrandModel;
use Maatwebsite\Excel\Concerns\ToModel;

class BrandModelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BrandModel([
            //
        ]);
    }
}
