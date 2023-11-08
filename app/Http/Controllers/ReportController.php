<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Disposal;
use App\Models\Issuence;
use App\Models\Location;
use App\Models\Maintenance;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Timeline;
use App\Models\Transfer;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function getPrint(Request $request)
    {
        // dd($request);
        $start_date = $request->session()->get('start_date');
        $end_date = $request->session()->get('end_date');
        $location = $request->session()->get('location');
        $assettype = $request->session()->get('assettype');
        $status = $request->session()->get('status');
        $asset = $request->session()->get('asset');
        $employeeId=$request->session()->get('employee_id');
        $productNumber=$request->session()->get('product_number');

        $data=[];
        $data1=[];

        if($employeeId && $productNumber){
            $query = Issuence::query();
        if ($employeeId && $productNumber) {
            $query->where('employee_id', $employeeId);
        }
        $issuanceResults = $query->get();
        $data1 = [];
        foreach ($issuanceResults as $issuence) {
            $productIds = json_decode($issuence->product_id);

            $stockQuery = Stock::query()->whereIn('id', $productIds);
                $stockResults = $stockQuery->get();

            $data1[] = [
                'employee_id' => $issuence->employee_id,
                'product_id' => $productIds,
                'stock_data' => $stockResults,
            ];
        }
            // dd($data);
        }
        elseif($assettype == 1){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data1 = $query->get();
            return view('Backend.Page.Reports.pdf.asset-active',compact('location','status','assettype','asset','data1'));
        }
        elseif($assettype == 2){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            $data2 = $query->get();
            foreach ($data2 as $product) {
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
            foreach ($data2 as $data) {
                $scrappedCount = Disposal::where('product_info', $data->id)->count();
            }
            $availableQuantity = $data2->pluck('availableQuantity');
            $allottedCount = $this->countStatus($data2, [2, 3]);
            $underRepairCount = $this->countStatus($data2, [12]);
            $transferredCount = $this->countStatus($data2, [5, 8]);
            $columns = ['SL', 'Asset Code', 'Asset', 'Brand', 'Brand Model', 'Specification', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Under Repair', 'Stolen', 'Scraped', 'Allocations'];
            return view('Backend.Page.Reports.pdf.asset-active',compact('data2', 'availableQuantity', 'allottedCount', 'underRepairCount', 'scrappedCount', 'transferredCount','columns'));
        }
        if($assettype == 3){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data3 = $query->get();

            foreach ($data3 as $product) {
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
            $allottedCount = $this->countStatus($data3, [2, 3]);
            $transferredCount = $this->countStatus($data3, [5, 8]);
            $availableQuantity = $data3->pluck('availableQuantity');
            $columns = ['SL', 'Asset Code', 'Asset', 'Configuration', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Allocations'];
            return view('Backend.Page.Reports.pdf.asset-active',compact('data3','availableQuantity','columns','allottedCount', 'transferredCount'));
        }
        if ($assettype == 4) {
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data4 = $query->get();

            foreach ($data4 as $product) {
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
            foreach ($data4 as $data) {
                $scrappedCount = Disposal::where('product_info', $data->id)->count();
            }
            $allottedCount = $this->countStatus($data4, [2, 3]);
            $underRepairCount = $this->countStatus($data4, [12]);
            $transferredCount = $this->countStatus($data4, [5, 8]);
            $availableQuantity = $data4->pluck('availableQuantity');
            $columns = ['SL', 'Asset Code', 'Asset', 'Brand', 'Brand Model', 'Specification', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Under Repair', 'Stolen', 'Scraped', 'Allocations'];

            return view('Backend.Page.Reports.pdf.asset-active', compact('data4', 'columns','availableQuantity', 'allottedCount', 'underRepairCount', 'scrappedCount', 'transferredCount'));
        }
    }

    public function getComponent()
    {
        $id = '4';
        $component = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.Reports.pdf.component-activity', compact('component'));
    }
    public function getMaintenance()
    {
        $maintenance = Maintenance::all();
        return view('Backend.Page.Reports.pdf.maintenance', compact('maintenance'));
    }
    public function getSupplier()
    {
        $supplier = Stock::all();
        return view('Backend.Page.Reports.pdf.supplier', compact('supplier'));
    }
    public function getLocation()
    {
        $location = Stock::all();
        return view('Backend.Page.Reports.pdf.report-location', compact('location'));
    }
    public function getType()
    {
        $report = Stock::all();
        return view('Backend.Page.Reports.pdf.type', compact('report'));
    }
    public function getStatus()
    {
        $report = Stock::all();
        return view('Backend.Page.Reports.pdf.status', compact('report'));
    }
    public function generatePDF(Request $request)
    {
        $start_date = $request->session()->get('start_date');
        $end_date = $request->session()->get('end_date');
        $location = $request->session()->get('location');
        $assettype = $request->session()->get('assettype');
        $status = $request->session()->get('status');
        $asset = $request->session()->get('asset');
        $employeeId=$request->session()->get('employee_id');
        $productNumber=$request->session()->get('product_number');

        $data=[];
        $data1=[];

        if($employeeId && $productNumber){
            $query = Issuence::query();
        if ($employeeId && $productNumber) {
            $query->where('employee_id', $employeeId);
        }
        $issuanceResults = $query->get();
        $data1 = [];
        foreach ($issuanceResults as $issuence) {
            $productIds = json_decode($issuence->product_id);

            $stockQuery = Stock::query()->whereIn('id', $productIds);
                $stockResults = $stockQuery->get();

            $data1[] = [
                'employee_id' => $issuence->employee_id,
                'product_id' => $productIds,
                'stock_data' => $stockResults,
            ];
        }
            // dd($data);
        }elseif($assettype == 1){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data1 = $query->get();
            $pdf = Pdf::loadView('Backend.Page.Reports.pdf.asset-active', compact('data1'));
            return $pdf->download('asset-active.pdf');
        }
        elseif($assettype == 2){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data2 = $query->get();;
            $pdf = Pdf::loadView('Backend.Page.Reports.pdf.asset-active', compact('data2'));
            return $pdf->download('asset-active.pdf');
        }
        if($assettype == 3){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data3 = $query->get();
            $pdf = Pdf::loadView('Backend.Page.Reports.pdf.asset-active', compact('data3'));
            return $pdf->download('asset-active.pdf');
        }
        if ($assettype == 4) {
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data4 = $query->get();

            $pdf = Pdf::loadView('Backend.Page.Reports.pdf.asset-active', compact('data4'));
            return $pdf->download('asset-active.pdf');
        }

        $pdf = Pdf::loadView('Backend.Page.Reports.pdf.asset-active', compact('datas'));
        return $pdf->download('asset-active.pdf');
    }

    public function pdfcomponent()
    {
        $id = '4';
        $component = Stock::where('asset_type_id', $id)->get();
        $comp = Pdf::loadView('Backend.Page.Reports.pdf.component-activity', compact('component'));
        return $comp->download('report-component.pdf');
    }
    public function pdfmaintenance()
    {
        $maintenance = Maintenance::all();
        $mainten = Pdf::loadView('Backend.Page.Reports.pdf.maintenance', compact('maintenance'));
        return $mainten->download('report-mainenance.pdf');
    }
    public function pdflocation()
    {
        $location = Stock::all();
        $locations = Pdf::loadView('Backend.Page.Reports.pdf.report-location', compact('location'));
        return $locations->download('report-location.pdf');
    }
    public function pdfsupplier()
    {
        $supplier = Stock::all();
        $suppliers = Pdf::loadView('Backend.Page.Reports.pdf.supplier', compact('supplier'));
        return $suppliers->download('reports-supplier.pdf');
    }
    public function pdftimeline($id)
    {
        $timeline = Timeline::find($id);
        if (!$timeline) {
            abort(404);
        }
        $data = [
            'timeline' => $timeline,
        ];
        $html = view('Backend.Page.Reports.pdf.gettimeline', $data)->render();
        $pdf = PDF::loadHTML($html);
        $image = $pdf->output();
        $imagePath = public_path('images/timeline-' . $id . '.jpg');
        file_put_contents($imagePath, $image);
        return response()->download($imagePath, 'timeline-' . $id . '.jpg')->deleteFileAfterSend(true);
    }
    public function pdftype()
    {
        $report = Stock::all();
        $reports = Pdf::loadView('Backend.Page.Reports.pdf.type', compact('report'));
        return $reports->download('report-type.pdf');
    }
    public function pdfstatus()
    {
        $report = Stock::all();
        $repo = Pdf::loadView('Backend.Page.Reports.pdf.status', compact('report'));
        return $repo->download('report-status.pdf');
    }
    public function allreport()
    {
        $data=null;
        $location = Location::all();
        $status=Status::all();
        $assettype = AssetType::all();
        $asset = Asset::all();
        return view('Backend.Page.Reports.all-reports',compact('location','status','assettype','asset'));
    }
    public function search_report(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $location = $request->input('location');
        $assettype = $request->input('assettype');
        $status = $request->input('status');
        $asset = $request->input('asset');
        $employeeId = $request->input('employee_id');
        $productNumber = $request->input('product_number');
        // $transaction = $request->input('transaction_code');
        $data=[];
        $data1=[];
        if($employeeId && $productNumber){
            $query = Issuence::query();
        if ($employeeId && $productNumber) {
            $query->where('employee_id', $employeeId);
        }
        $issuanceResults = $query->get();
        $data1 = [];
        foreach ($issuanceResults as $issuence) {
            $productIds = json_decode($issuence->product_id);

            $stockQuery = Stock::query()->whereIn('id', $productIds);
                $stockResults = $stockQuery->get();

            $data1[] = [
                'employee_id' => $issuence->employee_id,
                'product_id' => $productIds,
                'stock_data' => $stockResults,
            ];
        }
            // dd($data);
        }
        elseif($assettype == 1){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data1 = $query->get();

            $request->session()->put('start_date', $request->input('start_date'));
            $request->session()->put('end_date', $request->input('end_date'));
            $request->session()->put('location', $request->input('location'));
            $request->session()->put('assettype', $request->input('assettype'));
            $request->session()->put('status', $request->input('status'));
            $request->session()->put('asset', $request->input('asset'));
            $request->session()->put('employee_id',$request->input('employee_id'));
            $request->session()->put('product_number',$request->input('product_number'));
            $location = Location::all();
            $status = Status::all();
            $assettype = AssetType::all();
            $asset = Asset::all();
            return view('Backend.Page.Reports.all-reports',compact('location','status','assettype','asset','data1'));
        }
        elseif($assettype == 2){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            $data2 = $query->get();
            foreach ($data2 as $product) {
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
            foreach ($data2 as $data) {
                $scrappedCount = Disposal::where('product_info', $data->id)->count();
            }
            $availableQuantity = $data2->pluck('availableQuantity');
            $allottedCount = $this->countStatus($data2, [2, 3]);
            $underRepairCount = $this->countStatus($data2, [12]);
            $transferredCount = $this->countStatus($data2, [5, 8]);
            $columns = ['SL', 'Asset Code', 'Asset', 'Brand', 'Brand Model', 'Specification', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Under Repair', 'Stolen', 'Scraped', 'Allocations'];


            $request->session()->put('start_date', $request->input('start_date'));
            $request->session()->put('end_date', $request->input('end_date'));
            $request->session()->put('location', $request->input('location'));
            $request->session()->put('assettype', $request->input('assettype'));
            $request->session()->put('status', $request->input('status'));
            $request->session()->put('asset', $request->input('asset'));
            $request->session()->put('employee_id',$request->input('employee_id'));
            $request->session()->put('product_number',$request->input('product_number'));
            $location = Location::all();
            $status = Status::all();
            $assettype = AssetType::all();
            $asset = Asset::all();
            return view('Backend.Page.Reports.all-reports',compact('location','status','assettype','asset','data2', 'availableQuantity', 'allottedCount', 'underRepairCount', 'scrappedCount', 'transferredCount','columns'));
        }
        if($assettype == 3){
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data3 = $query->get();

            foreach ($data3 as $product) {
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
            $allottedCount = $this->countStatus($data3, [2, 3]);
            $transferredCount = $this->countStatus($data3, [5, 8]);
            $availableQuantity = $data3->pluck('availableQuantity');
            $columns = ['SL', 'Asset Code', 'Asset', 'Configuration', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Allocations'];

            $request->session()->put('start_date', $request->input('start_date'));
            $request->session()->put('end_date', $request->input('end_date'));
            $request->session()->put('location', $request->input('location'));
            $request->session()->put('assettype', $request->input('assettype'));
            $request->session()->put('status', $request->input('status'));
            $request->session()->put('asset', $request->input('asset'));
            $request->session()->put('employee_id',$request->input('employee_id'));
            $request->session()->put('product_number',$request->input('product_number'));
            $location = Location::all();
            $status = Status::all();
            $assettype = AssetType::all();
            $asset = Asset::all();
            return view('Backend.Page.Reports.all-reports',compact('location','status','assettype','asset','data3','availableQuantity','columns','allottedCount', 'transferredCount'));
        }
        if ($assettype == 4) {
            $query = Stock::where('asset_type_id', $assettype);

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($asset){
                $query->where('asset',$asset);
            }
            if($status){
                $query->where('status_available',$status);
            }
            if($start_date && $location && $assettype){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset && $status){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)->where('status_available', $status)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
             if($start_date && $location && $assettype && $asset){
                $query->where('location_id', $location)->where('asset_type_id', $assettype)
                ->where('asset', $asset)
                ->whereBetween('created_at', [$start_date, $end_date]);
             }
            if ($asset && $location && $assettype && $status) {
                $query->where('asset', $asset)
                    ->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($location && $assettype && $status) {
                $query->where('asset_type_id', $assettype)
                    ->where('status_available', $status)
                    ->where('location_id', $location);
            }
            if ($start_date && $location && $assettype) {
                $query->where('location_id', $location)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($status && $location) {
                $query->where('location_id',$location)->where('status_available', $status);
            }
            if($location){
                $query->where('location_id',$location);
            }
            if($start_date && $status){
                $query->where('status_available', $status)->whereBetween('created_at', [$start_date, $end_date]);
            }

            if ($start_date && $location && $asset && $assettype) {
                $query->where('location_id', $location)->where('asset', $asset)
                ->where('asset_type_id', $assettype)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data4 = $query->get();

            foreach ($data4 as $product) {
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
            foreach ($data4 as $data) {
                $scrappedCount = Disposal::where('product_info', $data->id)->count();
            }
            $allottedCount = $this->countStatus($data4, [2, 3]);
            $underRepairCount = $this->countStatus($data4, [12]);
            $transferredCount = $this->countStatus($data4, [5, 8]);
            $availableQuantity = $data4->pluck('availableQuantity');
            $columns = ['SL', 'Asset Code', 'Asset', 'Brand', 'Brand Model', 'Specification', 'Age', 'Quantity', 'In-stock', 'Allocated', 'Under Repair', 'Stolen', 'Scraped', 'Allocations'];

            $request->session()->put('start_date', $request->input('start_date'));
            $request->session()->put('end_date', $request->input('end_date'));
            $request->session()->put('location', $request->input('location'));
            $request->session()->put('assettype', $request->input('assettype'));
            $request->session()->put('status', $request->input('status'));
            $request->session()->put('asset', $request->input('asset'));
            $request->session()->put('employee_id',$request->input('employee_id'));
            $request->session()->put('product_number',$request->input('product_number'));
            $location = Location::all();
            $status = Status::all();
            $assettype = AssetType::all();
            $asset = Asset::all();

            return view('Backend.Page.Reports.all-reports', compact('location', 'status', 'assettype', 'asset', 'data4','columns','availableQuantity', 'allottedCount', 'underRepairCount', 'scrappedCount', 'transferredCount'));
        }

        return redirect()->back();
    }
    private function countStatus($data, $statusValues)
    {
        return $data->filter(function ($item) use ($statusValues) {
            return in_array($item->status_available, $statusValues);
        })->count();
    }
    public function activity_report()
    {

        $data = Stock::all();
        return view('Backend.Page.Reports.asset-active', compact('data'));
    }
    public function report_status()
    {
        $report = Issuence::all();

        return view('Backend.Page.Reports.reportstatus', compact('report'));
    }
    public function component_reports()
    {
        $id = '4';
        $component = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.Reports.component-activity-reports', compact('component'));
    }
    public function maintenance()
    {
        $maintenance = Maintenance::all();
        return view('Backend.Page.Reports.maintenance-report', compact('maintenance'));
    }
    public function report_type()
    {
        $report = Stock::all();
        return view('Backend.Page.Reports.report-type', compact('report'));
    }
    public function report_supplier()
    {
        $supplier = Stock::with('getsupplier', 'brand')->get();
        return view('Backend.Page.Reports.report-supplier', compact('supplier'));
    }
    public function report_location()
    {
        $location = Stock::all();
        return view('Backend.Page.Reports.report-location', compact('location'));
    }
}
