<?php

namespace App\Http\Controllers;

use App\Models\Asset;
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
        return view('Backend.Page.Reports.reportstatus');
    }
}
