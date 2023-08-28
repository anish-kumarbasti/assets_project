<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function maintenances()
    {
        return view('Backend.Page.Maintenance.index');
    }
    public function maintenance_save(Request $request)
    {
        return redirect('Backend.Page.Maintenance.index')->with('success', 'Asset Created Successfully');
    }
}
