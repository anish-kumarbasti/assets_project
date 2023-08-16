<?php
namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    public function index()
    {

        $assets = AssetType::all();
        return view('Backend.Page.Master.asset_type.index', compact('assets'));
    }

    public function create()
    {
        return view('Backend.Page.Master.asset_type.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',

        ]);

        $assetType=AssetType::create($request->all());

        return redirect()->route('assets-type-index')
                         ->with('success', 'Asset created successfully');
    }

    public function show(Asset $asset)
    {
        return view('Backend.Page.Master.asset_type.show', compact('asset'));
    }

    public function edit(AssetType $asset,$id)
    {
        $asset = AssetType::findOrFail($id);
        return view('Backend.Page.Master.asset_type.edit', compact('asset'));
    }

    public function update(Request $request, AssetType $asset)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $asset->update($request->all());

        return redirect()->route('assets-type-index')
                         ->with('success', 'Asset Type updated successfully');
    }
    public function assetTypeStatus(Request $request, $assetId)
    {

        $asset = AssetType::findOrFail($assetId);

        if($asset->status==true){
            AssetType::where('id',$assetId)->update([
                'status' => 0
            ]);
        }else{
            AssetType::where('id',$assetId)->update([
            'status' => 1
        ]);

        }

        return response()->json(['message' => 'Asset Type status updated successfully']);
    }
    public function destroy(AssetType $asset)
    {
        $asset->delete();
        return redirect()->route('assets-type-index')
                         ->with('success', 'Asset Type deleted successfully');
    }
}
