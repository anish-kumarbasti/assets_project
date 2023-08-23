<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IssuenceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employee =  User::with('department', 'location')->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')->first();
            return response()->json($employee);
        }
        return view('Backend.Page.Issuence.issuence');
    }
}
