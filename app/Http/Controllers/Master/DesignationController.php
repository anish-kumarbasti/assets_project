<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(){

        return view('Backend.Page.Master.designation');
    }
}
