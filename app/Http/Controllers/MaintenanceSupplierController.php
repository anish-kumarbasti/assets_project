<?php

namespace App\Http\Controllers;

use App\Exports\MaintenanceSupplier as ExportsMaintenanceSupplier;
use App\Imports\MaintenanceSupplier as ImportsMaintenanceSupplier;
use App\Models\MaintenanceSupplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MaintenanceSupplierController extends Controller
{
    public function index()
    {
        $suppliers = MaintenanceSupplier::all();
        return view('Backend.Page.Master.Maintenance_Supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('Backend.Page.Master.Maintenance_Supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:maintenance_suppliers',
            'phone' => 'required|numeric',
            'address' => 'required',
            'MaintenanceSupllierID' => 'required|unique:maintenance_suppliers',
        ]);

        MaintenanceSupplier::create($request->all());

        return redirect()->route('maintenance.suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = MaintenanceSupplier::find($id);
        return view('Backend.Page.Master.Maintenance_Supplier.edit', compact('supplier'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'MaintenanceSupllierID' => 'required',
        ]);

        MaintenanceSupplier::find($id)->update($request->all());

        return redirect()->route('maintenance.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(MaintenanceSupplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('maintenance.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
    public function export()
    {
        return Excel::download(new ExportsMaintenanceSupplier(), 'Maintenance_Supplier_format.xlsx');
    }
    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        // dd($request);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new ImportsMaintenanceSupplier(), $path)->first()->skip(1);
        foreach ($data as $row) {
            $brand = MaintenanceSupplier::updateOrCreate(
                ['MaintenanceSupllierID' => $row[0]],
                [
                    'name' => $row[1],
                    'email' => $row[2],
                    'phone' => $row[3],
                    'address' => $row[4],
                ]
            );
        }
        return redirect()->route('maintenance.suppliers.index')->with('message', 'Data imported successfully.');
    }
}
