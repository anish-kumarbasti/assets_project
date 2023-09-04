<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
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
        $request->validate([
            'employeeId'=>'required',
            'cardId'=>'required',
            'asset_type'=>'required',
            'asset'=>'required',
            'due_date'=>'required',
            'description'=>'nullable',
        ]);
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
        Issuence::create([
            'employee_id'=>$request->employeeId,
            'asset_type_id'=>$request->asset_type,
            'asset_id'=>$request->asset,
            'product_id'=>json_encode($request->cardId),
            'description'=>$request->description,
            'issuing_time_date'=>$dateTime,
            'due_date'=>$request->due_date,
        ]);
        return back()->with('success','Asset Issue!');
    }

}
