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
        $maintain = $request->validate([
            'assetType' => 'required',
            'supplier' => 'required',
            'assetName'    => 'required',
            'start_date' => 'required',
            'end_date'    => 'required',
        ]);
        // dd($request);

        Maintenance::Create([
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
        $validatedData = $request->validate([
            'asset' => 'required',
            'supplier' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $update = Maintenance::find($id);
        $update->asset = $validatedData['asset'];
        $update->supplier = $validatedData['supplier'];
        $update->type = $validatedData['type'];
        $update->start_date = $validatedData['start_date'];
        $update->end_date = $validatedData['end_date'];

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
