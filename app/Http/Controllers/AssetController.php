<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
{
    $assets = Asset::all();
    return view('Backend.Page.Master.assets.index', compact('assets'));
}

public function create()
{
    $assettype = AssetType::all();
    return view('Backend.Page.Master.assets.create', compact('assettype'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'assettype_id' => 'required|exists:asset_types,id', // Make sure assettype_id exists in asset_types table
    ]);

     $asset = new Asset;
    $asset->name = $request->name;
    $asset->assettype_id = $request->assettype_id;
    $asset->status = 1;
    $asset->save();

    session()->flash('success', 'Data has been successfully stored.');
    return redirect()->route('assets.index');
}
public function assetStatus(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);

        if($asset->status==true){
            Asset::where('id',$assetId)->update([
                'status' => 0
            ]);
        }else{
            Asset::where('id',$assetId)->update([
            'status' => 1
        ]);

        }

        return response()->json(['message' => 'Asset Type status updated successfully']);
    }
public function edit($id)
{
    $asset = Asset::findOrFail($id);
    $assetTypes = AssetType::all();
    return view('Backend.Page.Master.assets.edit', compact('asset','assetTypes'));
}

public function update(Request $request, $id)
{

    $assetType = Asset::findOrFail($id);
    $assetType->name = $request->name;
    $assetType->assettype_id = $request->assettype_id;
    $assetType->status = 1;
    $assetType->save();

    session()->flash('success', 'Data has been successfully Updated.');
    return redirect()->route('assets.index');
}

public function destroy($id)
{
    $asset = Asset::findOrFail($id);
    $asset->delete();

    return response()->json(['success' => true]);
}

}
