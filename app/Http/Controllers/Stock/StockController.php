<?php

namespace App\Http\Controllers\Stock;

use App\Helpers\TimelineHelper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Disposal;
use App\Models\Location;
use App\Models\Status;
use App\Models\Stock;
use App\Models\SubLocationModel;
use App\Models\Supplier;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

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
    private function countStatus($data, $statusValues)
    {
        return $data->filter(function ($item) use ($statusValues) {
            return in_array($item->status_available, $statusValues);
        })->count();
    }

    public function manage()
    {
        $stocks = Stock::all();
        $groupedStocks = [];

        foreach ($stocks as $stock) {
            $groupedStocks[] = [
                'product_number'=>$stock->product_number,
                'serial_number'=>$stock->serial_number,
                'product_info' => $stock->product_info,
                'asset_type' => $stock->asset_type->name,
                'assetmain' => $stock->assetmain->name??'',
                'instocks' => $this->countStatus(collect([$stock]),[1]),
                'allottedCount' => $this->countStatus(collect([$stock]), [2, 3]),
                'scrappedCount' => Disposal::where('product_info', $stock->id)->count(),
                'underRepairCount' => $this->countStatus(collect([$stock]), [12]),
                'stolen'=>$this->countStatus(collect([$stock]),[11]),
            ];
        }

        return view('Backend.Page.Stock.manage-stock', compact('groupedStocks'));
    }

    public function stockStatus()
    {

        $itAssetType = AssetType::where('name', 'IT Asset')->first();
        if (!$itAssetType) {
            return abort(404);
        }
        $stock = Stock::where(function ($query) {
            $query->where('status_available', 1)
            ->orWhere('status_available', 1);
        })->where('asset_type_id', $itAssetType->id)->get();
        foreach($stock as $product){
            $createdDate = $product->created_at;
            $currentDate = $product->product_warranty;
            $ageInYears = $createdDate->diffInYears($currentDate);
            $ageInMonths = $createdDate->diffInMonths($currentDate);

            $product -> ageInYears =$ageInYears;
            $product -> ageInMonths =$ageInMonths;
        }
        $allocated = Stock::where(function ($query) {
            $query->where('status_available', 2)
                ->orWhere('status_available', 3);
        })->where('asset_type_id', $itAssetType->id)->get();
        $stolen = Stock::where('status_available', 11)->where('asset_type_id', $itAssetType->id)->get();
        $scrapped = Stock::where('status_available', 11)->where('asset_type_id', $itAssetType->id)->get();
        $unrepair = Stock::where(function ($query) {
            $query->where('status_available', 6)
                ->orWhere('status_available', 12);
        })->where('asset_type_id', $itAssetType->id)->get();
        $transfer = Stock::where(function ($query) {
            $query->where('status_available', 5)
                ->orWhere('status_available', 8);
        })->where('asset_type_id', $itAssetType->id)->get();

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
        $request->validate([
            'asset_type'=>'required',
            'asset' =>'required',
            'price'=>'required',
            'product_info'=>'required',
            'generate_number'=>'required',
            'location'=>'required',
            'sublocation'=>'required',
            'supplier'=>'required',
            'specification' => [
                'max:255',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 100) {
                        $fail($attribute . ' must not exceed 100 words.');
                    }
                },
            ],
        ]);
        $filepath = '';
        if ($images = $request->file('image')) {
            $destinationPath = 'image';
            $imagess = date('YmdHis') . random_int(1, 10000) . "." . $images->getClientOriginalExtension();
            $images->move($destinationPath, $imagess);
            $filepath = $destinationPath . '/' . $imagess;
        }
        // dd($request);
        $product = Stock::create([
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
            'location_id' => $request->location,
            'sublocation_id' => $request->sublocation,
        ]);
        TimelineHelper::logAction('Product Created', $product->id, $request->asset_type, $request->asset);
        // You might want to redirect the user somewhere after successful creation
        return redirect()->back()->with('success', 'Stock created successfully!');
    }
    public function ShowStock()
    {
        $stock = Stock::with('statuses')->get();
        foreach($stock as $product){
            $createdDate = $product->created_at;
            $currentDate = $product->product_warranty;
            // $software = $product->expiry_date;
            // $software = !empty($currentDate) ? $currentDate : $product->expiry_date;
            $ageInYears = $createdDate->diffInYears($currentDate);
            $ageInMonths = $createdDate->diffInMonths($currentDate);

            $product -> ageInYears =$ageInYears;
            $product -> ageInMonths =$ageInMonths;
        }
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
            'product_info' => 'required',
            'asset_type'=>'required',
            'asset' =>'required',
            'price'=>'required',
            'generate_number'=>'required',
            'location'=>'required',
            'sublocation'=>'required',
            'supplier'=>'required',
        ]);

        $data = Stock::find($id)->update([
            'product_info' => $request->product_info,
            'asset_type_id' => $request->asset_type,
            'asset' => $request->asset,
            'brand_id' => $request->brand ?? '0',
            'brand_model_id' => $request->brand_model ?? '0',
            'location_id' => $request->location,
            'sublocation_id' => $request->sublocation,
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
    public function timeline($id)
    {
        $product = Timeline::where('product_id', $id)->with('user', 'product', 'issuance', 'transfer', 'disposal', 'maintenance', 'assetReturn')->get();
        return view('Backend.Page.Stock.timeline', compact('product'));
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return response()->json(['success'=>true]);
    }
    public function filter(Request $request)
    {
        $startdate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $data = Stock::with('assetmain', 'brandmodel', 'brand')->whereBetween('created_at', [$startdate, $endDate])->get();
        return response()->json($data);
    }
    public function trash(){
        $stock = Stock::onlyTrashed()->get();
        return view('Backend.Page.Stock.trash',compact('stock'));
    }
    public function restore($id){
        $restore=Stock::withTrashed()->findOrFail($id);
        if(!empty($restore)){
            $restore->restore();
        }
        return redirect()->route('all.stock')->with('success','Stock Restore Successfully');
    }
}
