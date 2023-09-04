<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
