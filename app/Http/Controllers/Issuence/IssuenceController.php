<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\IssuenceNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;

class IssuenceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // dd($request);
            $employee = User::with('department', 'designation')->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')->first();
            return response()->json($employee);
        }
        $assettype = AssetType::all();

        return view('Backend.Page.Issuence.issuence', compact('assettype'));
    }
    public function getassetdetail(Request $request)
    {
        // dd($request->serialNumber);
        if ($request->ajax()) {
            $response = Stock::with('brand', 'brandmodel','asset_type')
                ->where('serial_number', 'LIKE', '%' . $request->serialNumber . '%')
                ->orWhere('product_number', 'LIKE', '%' . $request->serialNumber . '%')
                ->first();
            // dd($response->brandmodel->name);
            return response()->json($response);
        }
    }
    public function getchangecard(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        $result = Stock::where('id', $requestData['cardId'])->with('brand', 'brandmodel')->get();
        // dd($result);
        return response()->json($result);
    }
    public function store(Request $request)
    {
        $request->validate([
            'employeeId' => 'required',
            'cardId' => 'required',
            'due_date' => 'required',
            'description' => 'nullable',
        ]);
        // dd($request);
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
        $issuence = Issuence::create([
            'employee_id' => $request->employeeId,
            'asset_type_id' => $request->asset_type,
            'asset_id' => $request->asset,
            'product_id' => json_encode($request->cardId),
            'description' => $request->description,
            'issuing_time_date' => $dateTime,
            'due_date' => $request->due_date,
        ]);
        $user = User::where('employee_id',$request->employeeId)->first();
        $user->notify(new IssuenceNotification($user));
        return back()->with('success', 'Asset Issued!');
    }

    public function markasread($id){
        if($id){
            auth()->user()->unreadNotifications->where('id',$id)->markAsRead();
        }
        return back();
    }

}
