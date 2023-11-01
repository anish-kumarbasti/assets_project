<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Disposal;
use App\Models\Issuence;
use App\Models\Maintenance;
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
            'name' => 'required|string|max:50|regex:/^[A-Za-z]+( [A-Za-z]+)*$/|min:2|unique:assets,name,except,id',
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
                'status' => 0,
            ]);
        } else {
            Asset::where('id', $assetId)->update([
                'status' => 1,
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
        $matchingData = Stock::where('asset_type_id', $id)->with('statuses')->get();
        // dd($matchingData);
        foreach ($matchingData as $product) {
            $issuanceCount = Issuence::whereJsonContains('product_id', $product->id)->count();
            $transferCount = Transfer::whereJsonContains('product_id', $product->id)->count();
            $maintenanceCount = Maintenance::where('product_id', $product->product_number)->count();
            $disposalCount = Disposal::where('product_info', $product->id)->count();
            $totalCount = $issuanceCount + $transferCount + $maintenanceCount + $disposalCount;
            $product->availableQuantity = $product->quantity - $totalCount;
            $createdDate = $product->created_at;
            $currentDate = $product->product_warranty;
            $ageInYears = $createdDate->diffInYears($currentDate);
            $ageInMonths = $createdDate->diffInMonths($currentDate);
            $product->ageInYears = $ageInYears;
            $product->ageInMonths = $ageInMonths;
        }
        $scrappedCount = [];
        foreach ($matchingData as $data) {
            $scrappedCount = Disposal::where('product_info', $data->id)->count();
        }
        $availableQuantity = $matchingData->pluck('availableQuantity');
        $allottedCount = $this->countStatus($matchingData, [2, 3]);
        $underRepairCount = $this->countStatus($matchingData, [12]);
        $transferredCount = $this->countStatus($matchingData, [5, 8]);
        $columns = ['SL', 'Asset Code', 'Asset', 'Brand', 'Brand Model', 'Specification', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Under Repair', 'Stolen', 'Scraped', 'Allocations'];
        return view('Backend.Page.It-Asset.non-it-stock', compact('matchingData', 'availableQuantity', 'allottedCount', 'underRepairCount', 'scrappedCount', 'transferredCount','columns'));
    }
    private function countStatus($data, $statusValues)
    {
        return $data->filter(function ($item) use ($statusValues) {
            return in_array($item->status_available, $statusValues);
        })->count();
    }
    public function allocation($id){
        $issuedata = Issuence::whereJsonContains('id', $id)->with('user')->get();
        $product = '';
        foreach ($issuedata as $data) {
            $product = Stock::where('id', $data->id)->get();
        }
        return view('Backend.Page.It-Asset.view-allocation-non-it', compact('issuedata','product'));
    }
    public function assetscomponent()
    {
        $id = '4';
        $assteComponent = Stock::where('asset_type_id', $id)->with('statuses')->get();
        // dd($assteComponent);
        foreach ($assteComponent as $product) {
            $issuanceCount = Issuence::whereJsonContains('product_id', $product->id)->count();
            $transferCount = Transfer::whereJsonContains('product_id', $product->id)->count();
            $maintenanceCount = Maintenance::where('product_id', $product->product_number)->count();
            $disposalCount = Disposal::where('product_info', $product->id)->count();
            $totalCount = $issuanceCount + $transferCount + $maintenanceCount + $disposalCount;
            $product->availableQuantity = $product->quantity - $totalCount;
            $createdDate = $product->created_at;
            $currentDate = $product->product_warranty;
            // $software = $product->expiry_date;
            // $software = !empty($currentDate) ? $currentDate : $product->expiry_date;
            $ageInYears = $createdDate->diffInYears($currentDate);
            $ageInMonths = $createdDate->diffInMonths($currentDate);

            $product->ageInYears = $ageInYears;
            $product->ageInMonths = $ageInMonths;
        }
        $scrappedCount = [];
        foreach ($assteComponent as $data) {
            $scrappedCount = Disposal::where('product_info', $data->id)->count();
        }
        $allottedCount = $this->countStatus($assteComponent, [2, 3]);
        $underRepairCount = $this->countStatus($assteComponent, [12]);
        $transferredCount = $this->countStatus($assteComponent, [5, 8]);
        $availableQuantity = $assteComponent->pluck('availableQuantity');
        $columns = ['SL', 'Asset Code', 'Asset', 'Brand', 'Brand Model', 'Specification', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Under Repair', 'Stolen', 'Scraped', 'Allocations'];
        return view('Backend.Page.It-Asset.assets-components', compact('assteComponent','columns','availableQuantity', 'allottedCount', 'underRepairCount', 'scrappedCount', 'transferredCount'));
    }
    public function getAssetsByType(Request $request, $id)
    {
        $assetTypeId = $request->input('assetTypeId');
        $assets = Asset::where('asset_type_id', $assetTypeId)->get();
        return response()->json($assets);
    }

    public function assetsoftware()
    {
        $id = '3';
        $softwareData = Stock::where('asset_type_id', $id)->get();
        foreach ($softwareData as $product) {
            $issuanceCount = Issuence::whereJsonContains('product_id', $product->id)->count();
            $transferCount = Transfer::whereJsonContains('product_id', $product->id)->count();
            $maintenanceCount = Maintenance::where('product_id', $product->product_number)->count();
            $disposalCount = Disposal::where('product_info', $product->id)->count();
            $totalCount = $issuanceCount + $transferCount + $maintenanceCount + $disposalCount;
            $product->availableQuantity = $product->quantity - $totalCount;
            $createdDate = $product->created_at;
            $currentDate = $product->expiry_date;
            $ageInYears = $createdDate->diffInYears($currentDate);
            $ageInMonths = $createdDate->diffInMonths($currentDate);

            $product->ageInYears = $ageInYears;
            $product->ageInMonths = $ageInMonths;
        }
        $allottedCount = $this->countStatus($softwareData, [2, 3]);
        $transferredCount = $this->countStatus($softwareData, [5, 8]);
        $availableQuantity = $softwareData->pluck('availableQuantity');
        $columns = ['SL', 'Asset Code', 'Asset', 'Configuration', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Allocations'];
        return view('Backend.Page.It-Asset.assets-software', compact('softwareData','availableQuantity','columns','allottedCount', 'transferredCount'));
    }
    public function getAssetDetails($assetTypeId)
    {
        $assetType = AssetType::findOrFail($assetTypeId);
        return response()->json([
            'assetType' => $assetType->name,
        ]);
    }
    public function getAssetDetailsonStock($id)
    {
        // Fetch asset details from your database based on the $id
        $asset = Stock::where('asset', $id)->with('assetmain', 'asset_type')->get();
        // dd  ($asset);
        if ($asset) {
            // Return the asset details as JSON
            return response()->json($asset);
        } else {
            // Handle the case when the asset is not found
            return response()->json(['error' => 'Asset not found'], 404);
        }
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
