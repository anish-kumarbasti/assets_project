<?php

namespace App\Http\Controllers\Disposal;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Disposal;
use Illuminate\Http\Request;

class DisposalController extends Controller
{
    public function index()
    {
        $assettype = AssetType::all();
        $asset = Asset::all();
        $disposal = Disposal::all();
        return view('Backend.Page.Disposal.disposal', compact('assettype', 'asset', 'disposal'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'assetType' => 'required', // Example: Valid values are Type1, Type2, Type3
            'assetName' => 'required', // Example: It should be a string
            'period_months' => 'required|integer|min:1', // Example: It should be a positive integer
            'product_name' => 'required', // Example: It should exist in the 'products' table
            'asset_value' => 'required|numeric|min:0.01', // Example: It should be a positive numeric value with at least 2 decimal places
            'desposal_code' => 'required|alpha_num', // Example: It should be alphanumeric
        ]);
        // dd($request);
        Disposal::create([
            'category'=>$request->assetType,
            'asset'=>$request->assetName ,
            'product_id'=>$request->product_name,
            'period_months'=>$request->period_months,
            'asset_value'=>$request->asset_value,
            'desposal_code'=>$request->desposal_code,
        ]);
        return redirect()->route('disposal')->with('success', 'Add Disposal successfully');
    }
    public function edit(Disposal $disposal, $id)
    {
        $disposal = Disposal::find($id);
        $asset = Asset::all();
        $assettype = AssetType::all();
        return view('Backend.Page.Disposal.edit', compact('disposal', 'asset', 'assettype'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'assetType' => 'required', // Example: Valid values are Type1, Type2, Type3
            'assetName' => 'required', // Example: It should be a string
            'period_months' => 'required|integer|min:1', // Example: It should be a positive integer
            'product_name' => 'required', // Example: It should exist in the 'products' table
            'asset_value' => 'required|numeric|min:0.01', // Example: It should be a positive numeric value with at least 2 decimal places
            'desposal_code' => 'required|alpha_num', // Example: It should be alphanumeric
        ]);

        $update = Disposal::find($id);
        $update->category = $request->assetType;
        $update->asset = $request->assetName;
        $update->period_months = $request->period_months;
        $update->product_id = $request->product_name;
        $update->asset_value = $request->asset_value;
        $update->desposal_code = $request->desposal_code;

        if ($update->save()) {
            return redirect()->route('disposal')->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }

    public function destroy($id)
    {
        $data = Disposal::find($id);
        if ($data) {
            $data->delete();
        }

        return response()->json(['success' => 'Record deleted successfully']);
    }
}
