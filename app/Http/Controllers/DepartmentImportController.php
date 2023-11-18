<?php

namespace App\Http\Controllers;

use App\Exports\DepartmentFormatExport;
use App\Imports\DepartmentImport;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentImportController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new DepartmentImport(), $path)->first()->skip(1);
        foreach($data as $row){
            Department::updateOrCreate(
                ['unique_id' => $row[1]],
                [
                    'name' => $row[0], 
                ]
            );
        }
        return redirect()->back()->with('message', 'Data imported successfully.');
    }
    public function downloadFormat()
    {
        return Excel::download(new DepartmentFormatExport(), 'department_format.xlsx');
    }
}
