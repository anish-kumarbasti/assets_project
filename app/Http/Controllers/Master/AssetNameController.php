<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetNameController extends Controller
{
    public function index(){

        return view('Backend.Page.Master.asset-name');
    }
}
