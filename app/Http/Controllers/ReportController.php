<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function getPrint()
    {
        $data = Asset::all();
        return view('Backend.Page.Reports.pdf.asset-active', compact('data'));
    }
    public function getComponent()
    {
        $id = '3';
        $component = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.Reports.pdf.component-activity', compact('component'));
    }
    public function getMaintenance()
    {
        $maintenance = Stock::all();
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
        $data = Asset::all();
        $pdf = Pdf::loadView('Backend.Page.Reports.Pdf.asset-active', compact('data'));
        return $pdf->download('asset-active.pdf');
    }
    public function pdfcomponent()
    {
        $id = '3';
        $component = Stock::where('asset_type_id', $id)->get();
        $comp = Pdf::loadView('Backend.Page.Reports.Pdf.component-activity', compact('component'));
        return $comp->download('report-component.pdf');
    }
    public function pdfmaintenance()
    {
        $maintenance = Stock::all();
        $mainten = Pdf::loadView('Backend.Page.Reports.Pdf.maintenance', compact('maintenance'));
        return $mainten->download('report-mainenance.pdf');
    }
    public function pdflocation()
    {
        $location = Stock::all();
        $locations = Pdf::loadView('Backend.Page.Reports.Pdf.report-location', compact('location'));
        return $locations->download('report-location.pdf');
    }
    public function pdfsupplier()
    {
        $supplier = Stock::all();
        $suppliers = Pdf::loadView('Backend.Page.Reports.Pdf.supplier', compact('supplier'));
        return $suppliers->download('reports-supplier.pdf');
    }
    public function pdftype()
    {
        $report = Stock::all();
        $reports = Pdf::loadView('Backend.Page.Reports.Pdf.type', compact('report'));
        return $reports->download('report-type.pdf');
    }
    public function pdfstatus()
    {
        $report = Stock::all();
        $repo = Pdf::loadView('Backend.Page.Reports.Pdf.status', compact('report'));
        return $repo->download('report-status.pdf');
    }
    public function allreport()
    {
        return view('Backend.Page.Reports.all-reports');
    }
    public function activity_report()
    {
        $data = Asset::all();
        return view('Backend.Page.Reports.asset-active', compact('data'));
    }
    public function report_status()
    {
        $report = Stock::all();
        return view('Backend.Page.Reports.reportstatus', compact('report'));
    }
    public function component_reports()
    {
        $id = '3';
        $component = Stock::where('asset_type_id', $id)->get();
        return view('Backend.Page.Reports.component-activity-reports', compact('component'));
    }
    public function maintenance()
    {
        $maintenance = Stock::all();
        return view('Backend.Page.Reports.maintenance-report', compact('maintenance'));
    }
    public function report_type()
    {
        $report = Stock::all();
        return view('Backend.Page.Reports.report-type', compact('report'));
    }
    public function report_supplier()
    {
        $supplier = Stock::all();
        return view('Backend.Page.Reports.report-supplier', compact('supplier'));
    }
    public function report_location()
    {
        $location = Stock::all();
        return view('Backend.Page.Reports.report-location', compact('location'));
    }
}
