<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Stock;
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
            'name' => 'required|unique:assets', // Check for uniqueness in the "assets" table
            'assettype_id' => 'required|exists:asset_types,id',
        ]);

        // If the validation passes, it means the asset is unique, so you can create it
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
        return view('Backend.Page.Master.assets.edit', compact('asset', 'assetTypes'));
    }

    public function update(Request $request, $id)
    {

        $assetType = Asset::findOrFail($id);
        $assetType->name = $request->name;
        $assetType->asset_type_id = $request->asset_type_id;
        $assetType->status = 1;
        $assetType->save();

        session()->flash('success', 'Data has been successfully Updated.');
        return redirect()->route('assets.index');
    }


    public function destroy($id)
    {
        $asset = Asset::find($id);
        if ($asset) {
            $asset->delete();
        }
        // $asset->delete();

        return response()->json(['success' => true]);
    }


    public function nonitasset()
    {
        $id = '2';
        $matchingData = Stock::where('asset_type_id', $id)->get();

        return view('Backend.Page.It-Asset.non-it-stock', compact('matchingData'));
    }
    public function assetscomponent()
    {
        $id = '3';
        $assteComponent = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.It-Asset.assets-components', compact('assteComponent'));
    }
    public function assetsoftware()
    {
        $id = '4';
        $softwareData = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.It-Asset.assets-software', compact('softwareData'));
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
    public function views()
    {
        return view('Backend.Page.Stock.timeline');
    }
    public function compotimeline()
    {
        return view('Backend.Page.Stock.timeline');
    }
    public function softwaretimeline()
    {
        return view('Backend.Page.Stock.timeline');
    }
}
