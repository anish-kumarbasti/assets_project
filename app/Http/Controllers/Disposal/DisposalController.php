<?php

namespace App\Http\Controllers\Disposal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DisposalController extends Controller
{
    public function index(){

        return view('Backend.Page.Disposal.disposal');
    }
}
