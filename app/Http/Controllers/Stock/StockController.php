<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Location;
use App\Models\Stock;
use App\Models\SubLocationModel;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function  index(Request $request)
    {
        $asset_type = AssetType::all();
        $asset = Asset::all();
        $brand = Brand::all();
        $location = Location::all();
        $brand_model = Brandmodel::all();
        $sublocation = SubLocationModel::all();
        // dd($asset_type);
        return view('Backend.Page.Stock.add-stock', compact('asset_type', 'asset', 'brand', 'location', 'brand_model', 'sublocation'));
    }

    public function getBrandModels($brandId)
    {
        $brandModels = BrandModel::where('brand_id', $brandId)->get();
        return response()->json(['models' => $brandModels]);
    }

    public function getslocation($locationId)
    {
        $slocations = SubLocationModel::where('location_id', $locationId)->get();
        return response()->json(['locations' => $slocations]);
    }


    public function  manage()
    {

        return view('Backend.Page.Stock.manage-stock');
    }

    public function  stockStatus()
    {

        return view('Backend.Page.Stock.stock-status');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_info' => 'required',
            'asset_type' => 'required',
            'asset' => 'required',
            'brand' => 'required',
            'brand_model' => 'required',
            'location' => 'required',
            'sublocation' => 'required',
            'configuration' => 'required',
            'serial_number' => 'required',
            'price' => 'required',
            'host_name' => 'required',
            'vendor' => 'required', // Fixed the typo here ('vedor' to 'vendor')
        ]);

        $data = Stock::create([
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand,
            'brand_model_id' => $request->brand_model,
            'location_id' => $request->location,
            'sublocation_id' => $request->sublocation,
            'configuration' => $request->configuration,
            'serial_number' => $request->serial_number,
            'price' => $request->price,
            'vendor' => $request->vendor,
            'host_name' => $request->host_name,
            'product_number' => $request->generate_number,
            'product_warranty' => $request->product_warranty,

        ]);

        // You might want to redirect the user somewhere after successful creation
        return redirect()->back()->with('success', 'Stock created successfully!');
    }
    public function ShowStock()
    {
        $stock = Stock::all();
        return view('Backend.Page.Stock.all-stock', compact('stock'));
    }
    public function ChangeStockStatus(Request $request, $stockId)
    {

        $asset = Stock::findOrFail($stockId);

        if ($asset->status == true) {
            Stock::where('id', $stockId)->update([
                'status' => 0
            ]);
        } else {
            Stock::where('id', $stockId)->update([
                'status' => 1
            ]);
        }

        return response()->json(['message' => 'Stock status updated successfully']);
    }
    public function edit($id)
    {
        $stockedit = Stock::find($id);
        $asset_type = AssetType::all();
        $asset = Asset::all();
        $brand = Brand::all();
        $location = Location::all();
        $brand_model = Brandmodel::all();
        $sublocation = SubLocationModel::all();
        return view('Backend.Page.Stock.add-stock', compact('stockedit', 'asset', 'asset_type', 'brand', 'brand_model', 'location', 'sublocation'));
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'product_info' => 'required',
            'asset_type' => 'required',
            'asset' => 'required',
            'brand' => 'required',
            'brand_model' => 'required',
            'location' => 'required',
            'sublocation' => 'required',
            'configuration' => 'required',
            'serial_number' => 'required',
            'price' => 'required',
            'vendor' => 'required', // Fixed the typo here ('vedor' to 'vendor')
        ]);

        $data = Stock::find($id)->update([
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand,
            'brand_model_id' => $request->brand_model,
            'location_id' => $request->location,
            'sublocation_id' => $request->sublocation,
            'configuration' => $request->configuration,
            'serial_number' => $request->serial_number,
            'price' => $request->price,
            'vendor' => $request->vendor,
        ]);

        // You might want to redirect the user somewhere after successful creation
        return redirect()->route('all.stock')->with('success', 'Stock Updated successfully!');
    }
    public function timeline()
    {
        return view('Backend.Page.Stock.timeline');
    }
}
