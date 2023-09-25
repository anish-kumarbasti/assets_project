<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use App\Models\AssetRejection;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Location;
use App\Models\Role;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\IssuenceNotification;
use App\Notifications\TransferNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $location = Location::all();
        return view('Backend.Page.Issuence.issuence', compact('assettype', 'location'));
    }
    public function getassetdetail(Request $request)
    {
        // dd($request->serialNumber);
        if ($request->ajax()) {
            $response = Stock::with('brand', 'brandmodel', 'asset_type')
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
            'location_id' => 'required',
            'sublocation_id' => 'required',
        ]);
        // dd($request);
        $product = json_encode($request->cardId);
        $user = User::where('employee_id', $request->employeeId)->first();
        $managerUser = User::where('role_id', 3)->where('department_id', $user->department_id)->first() ?? null;
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
        $issuence = Issuence::create([
            'employee_id' => $request->employeeId,
            'asset_type_id' => $request->asset_type,
            'asset_id' => $request->asset,
            'product_id' => json_encode($request->cardId),
            'description' => $request->description,
            'issuing_time_date' => $dateTime,
            'due_date' => $request->due_date,
            'location_id' => $request->location_id,
            'sub_location_id' => $request->sublocation_id,
            'employee_manager_id' => $managerUser->id,
        ]);
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assetmanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $user->department_id)->first() ?? null;
        $user->notify(new IssuenceNotification($user));
        if ($managerUser != null) {
            $managerUser->notify(new IssuenceNotification($managerUser));
        }
        if ($assetmanager != null) {
            $assetmanager->notify(new IssuenceNotification($assetmanager));
        }
        $stock = Stock::where('id',$request->cardId)->first();
        $data = ['name'=>$request->first_name.' '.$request->last_name,
                 'company_name'=>'IT-Asset',
                 'employee_id'=>$request->employee_id,
                 'email'=>$request->email,
                 'product_name'=>$tock->product_info.' '.$stock->assetmain->name,
                 'product_serial'=>$stock->serial_number,
                 'product_time'=>$dateTime,
                ];
        $users['to']=$user->email;
        Mail::send('backend.auth.mail.issuance_mail', $data, function ($message) use ($users) {
            $message->from('itasset@svamart.com', 'itasset@svamart.com'); // Replace with your email and name
            $message->to($users['to']);
            $message->subject('Asset Isuued Succesfully.');
        });
        return back()->with('success', 'Asset Issued!');
    }

    public function markasread($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        return view('Backend.Page.Issuence.accept', compact('products', 'issuedata'));
    }
    public function markasreadmanager($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->orderByDesc('created_at')
            ->first();
        $transferdata = Transfer::where('employee_id',$issuedata->employee_id)->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::where('employee_id', $issuedata->employee_id)->first();
        $transferuser = User::where('employee_id',$transferdata->handover_employee_id??'')->first();
        $users = DB::table('notifications')->Where('type','App\Notifications\TransferNotification')->first();
        return view('Backend.Page.Issuence.accept', compact('products', 'issuedata','user','users','transferuser'));
    }
    public function markasreadcontroller($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return back();
    }
    public function AssetAccept($id)
    {
        if(Auth::user()->role_id == 2){
        $status = Status::where('name', 'Accepted by User')->orWhere('name', 'Rejected')->first();
        Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
        return redirect()->route('user-dashboard')->with('success', 'Asset Alloted!');
        }else{
            $status = Status::where('name', 'Transferred')->first();
            Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
            return redirect()->route('user-dashboard')->with('success', 'Asset Alloted!');  
        }
    }
    public function AssetAcceptmanager($id)
    {
        $status = Status::where('name', 'Transferred by Manager')->first();
        Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
        $user = Auth::user();
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assetmanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $user->department_id)->first();
        $assetmanager->notify(new TransferNotification($assetmanager));
        return redirect()->route('user-dashboard')->with('success', 'Asset Transferred!');
    }
    public function showAll()
    {
        $issuences = DB::table('issuences')
            ->select('issuences.*', 'stocks.*')
            ->join('stocks', 'issuences.product_id', 'like', DB::raw('CONCAT("%", stocks.id, "%")'))
            ->get();
        return view('Backend.Page.Issuence.all-issuence', compact('issuences'));
    }
    public function AssetAcceptdetail($id)
    {
        $data = Stock::find($id);
        return view('Backend.Page.Issuence.accept-detail', compact('data'));
    }
    public function rejection(Request $request)
    {
        $request->validate([
            'reason' => 'required',
        ]);
        $authuser = Auth::user()->id;
        AssetRejection::create([
            'rejection_by_user' => $authuser,
            'reason' => $request->reason,
        ]);
        $status = Status::where('name', 'Rejected')->first();
        Stock::updateOrCreate(['id' => $request->productIdToReject], ['status_available' => $status->id]);
        return back()->with('success', 'Asset Rejected!');
    }
}
