<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index(){

        return view('Backend.Page.Transfer.transfer');
    }
}
