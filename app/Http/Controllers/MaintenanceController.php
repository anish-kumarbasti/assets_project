<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Maintenance;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function maintenances()
    {
        $asset = Asset::all();
        $supplier = Supplier::all();
        $assettype = AssetType::all();
        $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.index', compact('asset', 'supplier', 'assettype', 'maintain'));
    }
    public function maintenance_save(Request $request)
    {
        $request->validate([
            'assetType' => 'required', // Example: Valid values are Type1, Type2, Type3
            'supplier' => 'required', // Example: It should be a string
            'assetName' => 'required', // Example: It should be a string
            'start_date' => 'required|date', // Example: It should be a valid date
            'end_date' => 'required|date|after:start_date', // Example: It should be a valid date and after start_date
            'asset_number'=>'required',
            'product_name' => 'required', // Example: It should be a string
        ]);
        // dd($request);
        Maintenance::Create([
            'product_id'=>$request->product_name,
            'asset_type_id'=>$request->assetType,
            'asset_id'=>$request->assetName,
            'asset_number'=>$request->asset_number,
            'supplier_id'=>$request->supplier,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
        ]);
        return redirect()->route('assets-maintenances')->with('success', 'Asset Created Successfully');
    }
    public function edit(Maintenance $maintenance, $id)
    {
        $maintainance = Maintenance::find($id);
        $asset = Asset::all();
        $supplier = Supplier::all();
        $assettype = AssetType::all();
        $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.edit', compact('maintainance', 'asset', 'supplier', 'assettype', 'maintain'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_number'=>'required',
            'start_date' => 'required|date', // Example: It should be a valid date
            'end_date' => 'required|date|after:start_date', // Example: It should be a valid date and
        ]);

        $update = Maintenance::find($id);

        // Check if request has assetType, if not, use the existing value
        $update->asset_type_id = isset($request->assetType) ? $request->assetType : $update->asset_type_id;

        // Check if request has supplier, if not, use the existing value
        $update->supplier_id = isset($request->supplier) ? $request->supplier : $update->supplier_id;

        // Check if request has assetName, if not, use the existing value
        $update->asset_id = isset($request->asset) ? $request->asset : $update->asset_id;
        $update->asset_number = $request->asset_number;
        $update->start_date = $request->start_date;
        $update->end_date = $request->end_date;

        // Check if request has product_name, if not, use the existing value
        $update->product_id = isset($request->product_name) ? $request->product_name : $update->product_id;

        if ($update->save()) {
            return redirect()->route('assets-maintenances')->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }



    public function destroy($id)
    {
        $data = Maintenance::find($id);
        if ($data) {
            $data->delete();
        }

        return response()->json(['success' => 'Record deleted successfully']);
    }
}
