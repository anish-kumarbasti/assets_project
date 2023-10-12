<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Timeline;

class SearchController extends Controller
{
 public function searchAll(){
    $users=null;
    $stocks=null;
    return view('Backend.search-master', compact('users','stocks'));
    }
 public function search(Request $request)   
   {
    $keyword = $request->input('keyword');
    $active_tab = $request->input('active_tab');
       
        if ($active_tab == 'employee') {
            $stocks=null;
            $users = User::where(function($query) use ($keyword) {
                $query->where('first_name', 'like', "%$keyword%")
                    ->orWhere('last_name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('mobile_number', 'like', "%$keyword%")
                    ->orWhere('employee_id', 'like', "%$keyword%");
                   })->get();

    return view('Backend.search-master', compact('users','stocks'));

}
if($active_tab=='asset'){
    
    $users=null;
    $stocks = Stock::with('asset_type', 'assetmain', 'brand','statuses')
             ->where(function($query) use ($keyword) {
        $query->where('product_info', 'like', "%$keyword%")
            ->orWhere('serial_number', 'like', "%$keyword%")
            ->orWhere('product_number', 'like', "%$keyword%")
            ->orWhere('atribute_value', 'like', "%$keyword%");
           })->get();
        //    dd($stocks);
           return view('Backend.search-master', compact('stocks','users'));
}

}

public function userTimeline($id){
    $userTimelines = Timeline::with('product')->where('user_id', $id)->get();
    if($userTimelines){
        return view('Backend.user-timeline', compact('userTimelines'));
    }

  
}
public function stockTimeline($id){
    $stockTimelines = Timeline::with('user','issuance','transfer','disposal','maintenance','assetReturn')->where('product_id', $id)->get();
    if($stockTimelines){
        return view('Backend.stock-timeline', compact('stockTimelines'));
    }

  
}

}
