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
            'assetType' => 'required',
            'assetName' => 'required',
            'period_months' => 'required',
            'asset_value' => 'required',
            'desposal_code' => 'required',
        ]);
        // dd($request);
        Disposal::create([
            'category'=>$request->assetType,
            'asset'=>$request->assetName ,
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
        $validatedData = $request->validate([
            'category' => 'required',
            'asset' => 'required',
            'period_months' => 'required',
            'asset_value' => 'required',
            'desposal_code' => 'required',
        ]);

        $update = Disposal::find($id);
        $update->category = $validatedData['category'];
        $update->asset = $validatedData['asset'];
        $update->period_months = $validatedData['period_months'];
        $update->asset_value = $validatedData['asset_value'];
        $update->desposal_code = $validatedData['desposal_code'];

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
