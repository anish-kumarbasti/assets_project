<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Location;
use App\Models\Stock;
use App\Models\SubLocationModel;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function  index()
    {
        $asset_type = AssetType::all();
        $asset = Asset::all();
        $brand = Brand::all();
        $location = Location::all();
        $brand_model = Brandmodel::all();
        $sublocation = SubLocationModel::all();
        $attribute = Attribute::all();
        // dd($asset_type);
        return view('Backend.Page.Stock.add-stock',compact('asset_type','asset','brand','location','brand_model','sublocation','attribute'));
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

    public function getasset($assettypeId)
    {
        $assettypeId = Asset::where('asset_type_id', $assettypeId)->get();
        return response()->json(['assets' => $assettypeId]);
    }


    public function  manage()
    {

        return view('Backend.Page.Stock.manage-stock');
    }

    public function  stockStatus()
    {
        // $asset = Asset::where('name','IT Asset')->first();
        // dd($asset);
        // if($asset){
        //    Stock::where('asset_type_id') ;
        // }
        return view('Backend.Page.Stock.stock-status');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'product_info' => 'required',
            'price' => 'required',
            'vendor' => 'required', // Fixed the typo here ('vedor' to 'vendor')
        ]);
        // dd($request);
        $data = Stock::create([
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand??'0',
            'brand_model_id' => $request->brand_model??'0',
            // 'location_id' => $request->location,
            // 'sublocation_id' => $request->sublocation,
            'configuration' => $request->configuration,
            'serial_number' => $request->serial_number,
            'price' => $request->price,
            'vendor' => $request->vendor,
            'host_name' => $request->host_name,
            'product_number' => $request->generate_number,
            'product_warranty' => $request->product_warranty,
            'specification'=>$request->specification,
            'attribute'=>$request->attribute,
            'atribute_value'=>$request->attribute_value,
            'expiry_date'=>$request->expiry,
            'quantity'=>$request->quantity,
            'liscence_number'=>$request->liscence_number,
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
            'price' => 'required',
            'vendor' => 'required', // Fixed the typo here ('vedor' to 'vendor')
        ]);

        $data = Stock::find($id)->update([
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand??'0',
            'brand_model_id' => $request->brand_model??'0',
            // 'location_id' => $request->location,
            // 'sublocation_id' => $request->sublocation,
            'configuration' => $request->configuration,
            'serial_number' => $request->serial_number,
            'price' => $request->price,
            'vendor' => $request->vendor,
            'host_name' => $request->host_name,
            'product_number' => $request->generate_number,
            'product_warranty' => $request->product_warranty,
            'specification'=>$request->specification,
            'attribute'=>$request->attribute,
            'atribute_value'=>$request->attribute_value,
            'expiry_date'=>$request->expiry,
            'quantity'=>$request->quantity,
            'liscence_number'=>$request->liscence_number,
        ]);

        // You might want to redirect the user somewhere after successful creation
        return redirect()->route('all.stock')->with('success', 'Stock Updated successfully!');
    }
    public function timeline()
    {
        return view('Backend.Page.Stock.timeline');
    }
}
