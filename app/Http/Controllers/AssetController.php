<?php

namespace App\Http\Controllers;

use App\Models\Asset;
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
    return view('Backend.Page.Master.assets.create');
}

public function store(Request $request)
{
    $asset = new Asset;
    $asset->name = $request->name;
    $asset->status =1; // Assuming you have a status field
    $asset->save();

    return redirect()->route('assets.index');
}

public function edit($id)
{
    $asset = Asset::findOrFail($id);
    return view('Backend.Page.Master.assets.edit', compact('asset'));
}

public function update(Request $request, $id)
{
    $asset = Asset::findOrFail($id);
    $asset->name = $request->name;
    $asset->status = 1;
    $asset->save();

    return redirect()->route('assets.index');
}

public function destroy($id)
{
    $asset = Asset::findOrFail($id);
    $asset->delete();

    return redirect()->route('assets.index');
}

}
