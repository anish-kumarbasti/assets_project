<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Location;
use App\Models\Status;
use App\Models\Stock;
use App\Models\SubLocationModel;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{

    public function index()
    {
        $asset_type = AssetType::all();
        $asset = Asset::all();
        $brand = Brand::all();
        $location = Location::all();
        $brand_model = Brandmodel::all();
        $sublocation = SubLocationModel::all();
        $attribute = Attribute::all();
        $supplier = Supplier::all();
        $status = Status::all();
        return view('Backend.Page.Stock.add-stock', compact('asset_type', 'asset', 'brand', 'location', 'brand_model', 'sublocation', 'attribute', 'supplier', 'status'));
    }

    // public function getAttribute($assettypeId)
    // {
    //     $attribute = Attribute::where('asset_type_id', $assettypeId)->get();
    //     return response()->json(['attribute'=>$attribute]);
    // }

    public function getslocation($locationId)
    {
        $slocations = SubLocationModel::where('location_id', $locationId)->get();
        return response()->json(['locations' => $slocations]);
    }

    public function getasset($assettypeId)
    {
        // return $assettypeId;
        $assettype = Asset::where('asset_type_id', $assettypeId)->get();
        $attribute = Attribute::where('asset_type_id', $assettypeId)->get();
        //return $attribute;

        // dd($assettypeId);
        return response()->json([
            'assets' => $assettype,
            'attribute' => $attribute,
        ]);
    }
    public function getproduct($producttypeId)
    {
        $producttypeId = Stock::where('asset', $producttypeId)->get();
        // dd($producttypeId);
        return response()->json(['product' => $producttypeId]);
    }
    public function getBrandModels($brandId)
    {
        $brandId = Brandmodel::where('brand_id', $brandId)->get();
        return response()->json(['models' => $brandId]);
    }

    public function manage()
    {
        // Retrieve the status counts
        $groupedStocks = Stock::select('product_info', 'asset_type_id', 'asset', DB::raw('COUNT(*) as count'))
            ->groupBy('product_info', 'asset_type_id', 'asset')
            ->get();
        // 
        return view('Backend.Page.Stock.manage-stock', compact('groupedStocks'));
    }

    public function stockStatus()
    {
        $stock = Stock::where('status_available', 1)->get();
        $allocated = Stock::where('status_available', 2)->get();
        $stolen = Stock::where('status_available', 11)->get();
        $scrapped = Stock::where('status_available', 12)->get();
        $unrepair = Stock::where('status_available', 6)->get();
        $transfer = Stock::where('status_available', 5)->get();
        return view('Backend.Page.Stock.stock-status', compact('stock', 'allocated', 'unrepair', 'transfer', 'stolen', 'scrapped'));
    }

    public function generateNumber(Request $request)
    {
        // $randomNumber = mt_rand(10000, 99999);
        $randomNumber = 'ABSC' . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

        return response()->json(['number' => $randomNumber]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'price' => 'required|integer',
        //     'product_info' => 'required', ]);
        // dd($request);
        $filepath = '';
        if ($images = $request->file('image')) {
            $destinationPath = 'image';
            $imagess = date('YmdHis') . random_int(1, 10000) . "." . $images->getClientOriginalExtension();
            $images->move($destinationPath, $imagess);
            $filepath = $destinationPath . '/' . $imagess;
        }
        // dd($request);
        Stock::create([
            'status_available' => $request->status,
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand ?? '0',
            'brand_model_id' => $request->brand_model ?? '0',
            'configuration' => $request->configuration,
            'serial_number' => $request->serial_number,
            'price' => $request->price,
            'host_name' => $request->host_name,
            'product_number' => $request->generate_number,
            'product_warranty' => $request->product_warranty,
            'specification' => $request->specification,
            'attribute' => $request->attribute,
            'atribute_value' => $request->attribute_value,
            'expiry_date' => $request->expiry,
            'quantity' => $request->quantity,
            'liscence_number' => $request->liscence_number,
            'supplier' => $request->supplier,
            'image' => $filepath,
        ]);

        // You might want to redirect the user somewhere after successful creation
        return redirect()->back()->with('success', 'Stock created successfully!');
    }
    public function ShowStock()
    {
        $stock = Stock::with('statuses')->get();
        return view('Backend.Page.Stock.all-stock', compact('stock'));
    }
    public function ChangeStockStatus(Request $request, $stockId)
    {

        $asset = Stock::findOrFail($stockId);

        if ($asset->status == true) {
            Stock::where('id', $stockId)->update([
                'status' => 0,
            ]);
        } else {
            Stock::where('id', $stockId)->update([
                'status' => 1,
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
        $attribute = Attribute::all();
        $supplier = Supplier::all();
        $status = Status::all();
        return view('Backend.Page.Stock.add-stock', compact('stockedit', 'asset', 'asset_type', 'brand', 'brand_model', 'location', 'sublocation', 'attribute', 'supplier', 'status'));
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'price' => 'required|integer|min:1',
            'product_info' => 'required|string|max:50',
        ]);

        $data = Stock::find($id)->update([
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand ?? '0',
            'brand_model_id' => $request->brand_model ?? '0',
            // 'location_id' => $request->location,
            // 'sublocation_id' => $request->sublocation,
            'configuration' => $request->configuration,
            'serial_number' => $request->serial_number,
            'price' => $request->price,
            // 'vendor' => $request->vendor,
            'host_name' => $request->host_name,
            'product_number' => $request->generate_number,
            'product_warranty' => $request->product_warranty,
            'specification' => $request->specification,
            'attribute' => $request->attribute,
            'atribute_value' => $request->attribute_value,
            'expiry_date' => $request->expiry,
            'quantity' => $request->quantity,
            'liscence_number' => $request->liscence_number,
            'supplier' => $request->supplier ?? '0',
        ]);

        // You might want to redirect the user somewhere after successful creation
        return redirect()->route('all.stock')->with('success', 'Stock Updated successfully!');
    }
    public function timeline()
    {
        return view('Backend.Page.Stock.timeline');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('all.stock');
    }
}
