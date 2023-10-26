<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Location;
use App\Models\Maintenance;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Timeline;
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
        }else{
            $query = Stock::query();
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($status===null && $asset===null && $location===null && $assettype===null && $start_date){
                $query->whereBetween('created_at',[$start_date,$end_date]);
            }
            if($assettype){
                $query->where('asset_type_id', $assettype);
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
            $datas = $query->get();
        }

        // dd($datas);
        return view('Backend.Page.Reports.pdf.asset-active', compact('datas'));
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
        }else{
            $query = Stock::query();
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($status===null && $asset===null && $location===null && $assettype===null && $start_date){
                $query->whereBetween('created_at',[$start_date,$end_date]);
            }
            if($assettype){
                $query->where('asset_type_id', $assettype);
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
            $datas = $query->get();
        }
        // dd($datas);

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
        }else{
            $query = Stock::query();
            if ($start_date && $location) {
                $query->where('location_id', $location)
                    ->whereBetween('created_at', [$start_date, $end_date]);
            }
            if($status===null && $asset===null && $location===null && $assettype===null && $start_date){
                $query->whereBetween('created_at',[$start_date,$end_date]);
            }
            if($assettype){
                $query->where('asset_type_id', $assettype);
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
            $data = $query->get();
        }

        // dd($data);
        // dd($data1);
        $request->session()->put('start_date', $request->input('start_date'));
        $request->session()->put('end_date', $request->input('end_date'));
        $request->session()->put('location', $request->input('location'));
        $request->session()->put('assettype', $request->input('assettype'));
        $request->session()->put('status', $request->input('status'));
        $request->session()->put('asset', $request->input('asset'));
        $request->session()->put('employee_id',$request->input('employee_id'));
        $request->session()->put('product_number',$request->input('product_number'));
        $location = Location::all();
        $status=Status::all();
        $assettype = AssetType::all();
        $asset = Asset::all();
        return view('Backend.Page.Reports.all-reports',compact('location','status','assettype','asset','data'));
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
