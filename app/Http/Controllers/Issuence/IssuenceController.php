<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use App\Models\AssetType;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class IssuenceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // dd($request);
            $employee =  User::with('department', 'designation')->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')->first();
            return response()->json($employee);
        }
        $assettype=AssetType::all();

        return view('Backend.Page.Issuence.issuence',compact('assettype'));
    }
    public function getassetdetail($AssetDetail){
        $response = Stock::where('asset',$AssetDetail)->with('brand','brandmodel')->get();
        // dd($response);
        return response()->json($response);
    }
    public function getchangecard(Request $request) {
        $requestData = json_decode($request->getContent(), true);
        
        $result = Stock::where('id', $requestData['cardId'])->with('brand', 'brandmodel')->get();
        // dd($result);
        return response()->json($result);
    }
    public function store(Request $request){
        dd($request);
    }
    
}
