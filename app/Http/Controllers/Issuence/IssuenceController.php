<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IssuenceController extends Controller
{
    public function index(){

        return view('Backend.Page.Issuence.issuence');
    }
}
