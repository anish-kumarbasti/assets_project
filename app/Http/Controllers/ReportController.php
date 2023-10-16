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
    public function getPrint()
    {
        $data = Stock::all();

        return view('Backend.Page.Reports.pdf.asset-active', compact('data'));
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
    public function generatePDF()
    {
        $data = Stock::all();
        $pdf = Pdf::loadView('Backend.Page.Reports.pdf.asset-active', compact('data'));
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
        $location = Location::all();
        $status=Status::all();
        $assettype = AssetType::all();
        // $data = null;
        return view('Backend.Page.Reports.all-reports',compact('location','status','assettype'));
    }
    public function search_report(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $location = $request->input('location');
        $asset = $request->input('asset');
        $status = $request->input('status');

        $query = Stock::query();
        $query->when($location, function ($query) use ($location) {
            return $query->where('location_id', $location);
        })->when($asset, function ($query) use ($asset) {
            return $query->where('asset_type_id', $asset);
        })->when($status, function ($query) use ($status) {
            return $query->where('status_available', $status);
        });

        $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            return $query->whereBetween('created_at', [$start_date, $end_date]);
        });
        $data = $query->get();
        // dd($request);
        return view('Backend.Page.Reports.all-reports',compact('data'));
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
