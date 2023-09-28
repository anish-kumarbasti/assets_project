<?php

namespace App\Http\Controllers;

use App\Helpers\TimelineHelper;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Maintenance;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function receive()
    {
        $maintain = Maintenance::with('statuss', 'suppliers')->get();
        $status = Status::all();
        return view('Backend.Page.Maintenance.Receive.index', compact('maintain', 'status'));
    }
    public function maintenance_rep()
    {
        $maintain = Maintenance::all();
        $maintains = Pdf::loadView('Backend.Page.Maintenance.pdf.maintenance-reports', compact('maintain'));
        return $maintains->download('maintenance-reports.pdf');
    }
    public function maintenance_reports()
    {
        $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.pdf.maintenance-reports', compact('maintain'));
    }
    public function download($id)
    {
        $maintain = Maintenance::with('statuss', 'suppliers')->find($id);
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
        $maintain = Maintenance::with('statuss', 'suppliers')->get();
        $status = Status::all();
        return view('Backend.Page.Maintenance.index', compact('maintain', 'supplier', 'status'));
    }
    public function maintenance_save(Request $request)
    {
        // dd($request);
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'product_id' => 'required',
            'asset_number' => 'required',
            'supplier_id' => 'required|max:30',
            'asset_price' => 'required',
            'status' => 'required'
        ]);
        $product = Stock::where('product_number',$request->product_id)
                            ->orWhere('serial_number',$request->product_id)
                            ->first();
        $maintenance = Maintenance::Create([
            'product_id' => $request->product_id,
            'asset_number' => $request->asset_number,
            'status' => $request->status,
            'asset_price' => $request->asset_price,
            'supplier_id' => $request->supplier_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        Stock::where('product_number',$request->product_id)->update(['status_available'=>$request->status]);
        TimelineHelper::logAction('Product Maintenance', $product->id, $product->asset_type_id, $product->asset, null, null, null, null, null, null, $maintenance->id, $request->supplier_id);
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
            'asset_number' => 'required',
            'supplier_id' => 'required|max:30',
            'asset_price' => 'required'
        ]);
        $update = Maintenance::find($id);

        $update->product_id = $request->product_id;
        $update->asset_number = $request->asset_number;
        $update->status = $request->status;
        $update->asset_price = $request->asset_price;
        $update->supplier_id = $request->supplier_id;
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
    public function maintenance_edit($id)
    {
        $maintenanceData = Maintenance::findOrFail($id);
        if (!$maintenanceData) {
            return response()->json(['error' => 'JSON Data not Found']);
        }
        return response()->json($maintenanceData);
    }
    public function getSuppliers($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        return response()->json($supplier);
    }
    public function getStatuses()
    {
        $status = Status::all();
        return view('Backend.Page.Maintenance.Receive.index', compact('status'));
    }

    public function statusupdate(Request $request, $id)
    {
        $update = Maintenance::find($id);
        $update->product_id = $request->product_id;
        $update->asset_number = $request->asset_number;
        $update->status = $request->status;
        $update->asset_price = $request->asset_price;
        $update->supplier_id = $request->supplier_id;
        $update->start_date = $request->start_date;
        $update->end_date = $request->end_date;
        $update->update();

        return response()->json(['message' => 'Data updated successfully']);
    }
}
