<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function permission(){
        return view('Backend.Page.Role-Permission.permission');
        }
}
