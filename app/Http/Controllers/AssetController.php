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
        // dd($assets);
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
    $asset->asset_type_id = $request->assettype_id;
    $asset->status = 1;
    $asset->save();

    session()->flash('success', 'Data has been successfully stored.');
    return redirect()->route('assets.index');
}
public function assetStatus(Request $request, $assetId)

    {
        $asset = Asset::findOrFail($assetId);

        if ($asset->status == true) {
            Asset::where('id', $assetId)->update([
                'status' => 0
            ]);
        } else {
            Asset::where('id', $assetId)->update([
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
    $asset = Asset::find($id);
    if ($asset){
        $asset->delete();
    }
    // $asset->delete();

    return response()->json(['success' => true]);



}


    public function nonitasset()
    {
        return view('Backend.Page.It-Asset.non-it-stock');
    }
    public function assetscomponent()
    {
        return view('Backend.Page.It-Asset.assets-components');
    }
    public function assetsoftware()
    {
        return view('Backend.Page.It-Asset.assets-software');
    }
    public function getAssetDetails($assetTypeId)
{
    // Fetch the asset type details from the database
    $assetType = AssetType::findOrFail($assetTypeId);
    // dd($assetTypeId);

    // You can customize this part based on your database structure
    // Return a JSON response with the fetched data
    return response()->json([
        'assetType' => $assetType->name, // Assuming the column name is 'name'
        // Add other data you want to use in the script here
    ]);
}

}
