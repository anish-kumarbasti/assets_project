<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function  index(){
      
        return view('Backend.Page.Stock.add-stock');
    }

    public function  manage(){
      
        return view('Backend.Page.Stock.manage-stock');
    }
   
    public function  stockStatus(){
      
        return view('Backend.Page.Stock.stock-status');
    }

   
}
