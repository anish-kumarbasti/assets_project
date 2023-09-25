<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Issuence;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function index()
    {
        $auth = Auth::user()->employee_id;
        $data= Issuence::where('employee_id',$auth)->get();
        // dd($auth);
        return view('Backend.Page.Transfer.return',compact('data'));
    }
}
