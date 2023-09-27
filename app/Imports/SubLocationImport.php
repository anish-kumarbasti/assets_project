<?php

namespace App\Imports;

use App\Models\SubLocation;
use Maatwebsite\Excel\Concerns\ToModel;

class SubLocationImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubLocation([
            //
        ]);
    }
}
