<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Stock;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('AssetName')->get();
        // dd($assets);
        return view('Backend.Page.Master.assets.index', compact('assets'));
    }
    public function trash()
    {
        $assets = Asset::onlyTrashed('AssetName')->get();
        return view('Backend.Page.Master.assets.trash', compact('assets'));
    }
    public function restore($id)
    {
        $assets = Asset::withTrashed()->findOrFail($id);
        if (!empty($assets)) {
            $assets->restore();
        }
        return redirect()->route('assets.index')->with('success', 'Asset Restored Successfully');
    }
    public function forceDelete($id)
    {
        $assets = Asset::withTrashed()->find($id);

        if (!$assets) {
            return response()->json(['success' => false], 404);
        }

        $assets->forceDelete();

        return response()->json(['success' => true]);
    }


    public function create()
    {
        $assettype = AssetType::all();
        return view('Backend.Page.Master.assets.create', compact('assettype'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'asset_type_id' => 'required',
            'name' => 'required|string|max:50|regex:/^[A-Za-z]+( [A-Za-z]+)*$/|min:2',
        ]);
        $asset = new Asset;
        $asset->name = $request->name;
        $asset->asset_type_id = $request->asset_type_id;
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

        $request->validate([
            'asset_type_id' => 'required',
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);
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
        $id = '4';
        $assteComponent = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.It-Asset.assets-components', compact('assteComponent'));
    }
    public function assetsoftware()
    {
        $id = '3';
        $softwareData = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.It-Asset.assets-software', compact('softwareData'));
    }
    public function getAssetDetails($assetTypeId)
    {
        $assetType = AssetType::findOrFail($assetTypeId);
        return response()->json([
            'assetType' => $assetType->name,
        ]);
    }
    public function views()
    {
        return view('Backend.Page.Stock.timeline');
    }
    public function compotimeline($id)
    {
        $data = null;

        $data = Stock::where('id', $id)->first();

        if (!$data) {
            $data = Issuence::where('product_id', $id)->first();
        }

        if (!$data) {
            $data = Transfer::where('product_id', $id)->first();
        }

        return view('Backend.Page.Stock.timeline', compact('data'));
    }

    public function softwaretimeline()
    {
        return view('Backend.Page.Stock.timeline');
    }
}
