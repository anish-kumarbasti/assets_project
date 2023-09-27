<?php

namespace App\Imports;

use App\Models\AssetType;
use App\Models\Department;
use FontLib\Table\Type\name;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AssetType([

            'name'=>$row[0],
            'status'=> $row[1],
        ]);
    }
}
