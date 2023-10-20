<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function checkAll(){
       return view('Backend.Page.Issuence.check-all');
    }
}
