<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Maintenance;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function download()
    {
        $maintain = Maintenance::latest()->first();
        return view('Backend.Page.Maintenance.pdf.report', compact('maintain'));
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $product =  Stock::where('product_number', 'LIKE', '%' . $request->product_number . '%')->first();
            return response()->json($product);
        }
    }
    public function maintenances()
    {
        // $asset = Asset::all();
        $supplier = Supplier::all();
        // $assettype = AssetType::all();
        $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.index', compact('maintain', 'supplier'));
    }
    public function maintenance_save(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'product_id' => 'required',
            'asset' => 'required',
            'supplier' => 'required|max:30',
            'asset_price' => 'required'
        ]);
        // dd($request);
        Maintenance::Create([
            'product_id' => $request->product_id,
            'asset' => $request->asset,
            'status' => $request->status,
            'asset_price' => $request->asset_price,
            'supplier' => $request->supplier,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        return redirect()->route('assets-maintenances')->with('success', 'Asset Created Successfully');
    }
    public function edit(Maintenance $maintenance, $id)
    {
        $maintainance = Maintenance::find($id);
        // $asset = Asset::all();
        $supplier = Supplier::all();
        $status = Status::all();
        // $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.edit', compact('maintainance', 'supplier', 'status'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'product_id' => 'required',
            'asset' => 'required',
            'supplier' => 'required|max:30',
            'asset_price' => 'required'
        ]);
        $update = Maintenance::find($id);

        $update->product_id = $request->product_id;
        $update->asset = $request->asset;
        $update->status = $request->status;
        $update->asset_price = $request->asset_price;
        $update->supplier = $request->supplier;
        $update->start_date = $request->start_date;
        $update->end_date = $request->end_date;
        // // Check if request has assetType, if not, use the existing value
        // dd($update);
        // $update->asset_type_id = isset($request->assetType) ? $request->assetType : $update->asset_type_id;

        // // Check if request has supplier, if not, use the existing value
        // $update->supplier_id = isset($request->supplier) ? $request->supplier : $update->supplier_id;

        // // Check if request has assetName, if not, use the existing value
        // $update->asset_id = isset($request->asset) ? $request->asset : $update->asset_id;
        // $update->asset_number = $request->asset_number;
        // $update->start_date = $request->start_date;
        // $update->end_date = $request->end_date;

        // // Check if request has product_name, if not, use the existing value
        // $update->product_id = isset($request->product_name) ? $request->product_name : $update->product_id;

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
