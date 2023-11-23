<?php

namespace App\Http\Controllers;

use App\Helpers\TimelineHelper;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Maintenance;
use App\Models\MaintenanceSupplier;
use App\Models\MaintenanceUser;
use App\Models\Role;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Transfer;
use App\Models\TransferReason;
use App\Models\User;
use App\Notifications\MaintenanceNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function maintenanceUser(Request $request){
        $auth = Auth::user()->employee_id;
        $reason = TransferReason::all();
        $Issuestatus = Status::where('name', 'Accepted by User')->first();
        $Transferstatus = Status::where('name', 'Transferred')->first();
        $data = collect([]);
        $transfer = Transfer::where('handover_employee_id', $auth)->distinct()->pluck('product_id');
        $issuance = Issuence::where('employee_id', $auth)->distinct()->pluck('product_id');
        if ($transfer->isNotEmpty()) {
            foreach ($transfer as $transferItem) {
                $product_id = json_decode($transferItem);
                $transferData = Stock::whereIn('id', $product_id)
                    ->where(function ($query) use ($Issuestatus, $Transferstatus) {
                        $query->where('status_available', $Issuestatus->id)
                            ->orWhere('status_available', $Transferstatus->id);
                    })
                    ->get();
                $data = $data->concat($transferData);
            }
        }
        if ($issuance->isNotEmpty()) {
            foreach ($issuance as $issuanceItem) {
                $product_id = json_decode($issuanceItem);
                $issuanceData = Stock::whereIn('id', $product_id)
                    ->where(function ($query) use ($Issuestatus, $Transferstatus) {
                        $query->where('status_available', $Issuestatus->id)
                            ->orWhere('status_available', $Transferstatus->id);
                    })
                    ->get();
                $data = $data->concat($issuanceData);
            }
        }
        // dd($data);
        return view('Backend.Page.Maintenance.apply_user', compact('data', 'reason', 'auth'));
    }
    public function sendUser(Request $request){
        $request->validate([
            'selectedAssets'=>'required|array',
            'reason'=>'required',
            'description'=>'required',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assetmanager = User::where('role_id', $assetcontroller->id)
        ->where('department_id', $user->department_id)->first() ?? null;
        $random = 'MAINUS' . str_pad(mt_rand(1111111, 9999999), 5, '0', STR_PAD_LEFT);
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
        $usermaintenance = MaintenanceUser::create([
            'product_id'=>json_encode($request->selectedAssets),
            'maintenance_reason'=>$request->reason,
            'description'=>$request->description,
            'perform_by_user'=>Auth::user()->id,
            'controller_id'=>$assetmanager->id,
            'transaction_code'=>$random,
            'date_time'=>$dateTime,
            'status'=>Status::where('name', 'Maintainence Pending')->first()->id,
        ]);
        foreach ($request->selectedAssets as $productId) {
            $stock = Stock::find($productId);
            $stock->update([
                'status_available' => Status::where('name', 'Maintainence Pending')->first()->id,
            ]);
        }
        $assetmanager->notify(new MaintenanceNotification($assetmanager));
        return back()->with('success', 'Asset in Under Maintenance');
    }
    public function recieveasset($id)
    {
        // dd($id);
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Maintenance::where('id', $id)->get();
        $productIds = [];
        $createdDates = [];
        $userdetail = [];
        $transactioncode = [];
        $description = [];
        $datatime = '';
        foreach ($issuedata as $issuedatas) {
            $productIds[] = json_decode($issuedatas->product_id);
            $createdDates[] = $issuedatas->created_at;
            $userdetail[] = $issuedatas->maintenance_user_id;
            $transactioncode = $issuedatas->transaction_id;
            $description = $issuedatas->description;
            $datatime = $issuedatas->start_date;
        }
        $selectedAssetIds = collect($productIds)->flatten()->unique()->toArray();
        $products = Stock::whereIn('id', $selectedAssetIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get()->sortByDesc('status_available');
        return view('Backend.Page.Maintenance.recieve', compact('products', 'createdDates', 'transactioncode', 'description', 'datatime'));
    }
    public function AssetRecieve($id)
    {
        $status = Status::where('name', 'Accepted by User')->first();
        Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
        return redirect()->back()->with('success', 'Asset Recieved!');
    }
    public function receive()
    {
        $maintenance = Maintenance::with('statuss')->get();
        $status = Status::all();
        return view('Backend.Page.Maintenance.index', compact('maintenance', 'status'));
    }
    public function maintenance_rep()
    {
        $maintain = Maintenance::all();
        $maintains = Pdf::loadView('Backend.Page.Maintenance.pdf.maintenance-reports', compact('maintain'));
        return $maintains->download('maintenance-reports.pdf');
    }
    public function maintenance_reports()
    {
        $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.pdf.maintenance-reports', compact('maintain'));
    }
    public function download($id)
    {
        $maintain = Maintenance::with('statuss', 'suppliers')->find($id);
        return view('Backend.Page.Maintenance.pdf.report', compact('maintain'));
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $product =  Stock::where('product_number', 'LIKE', '%' . $request->product_number . '%')->first();
            return response()->json($product);
        }
    }
    public function maintenances()
    {
        $auth = Auth::user()->employee_id;
        $authid = Auth::id();
        $reason = TransferReason::all();
        // $Issuestatus = Status::where('name', 'Accepted by User')->first();
        // $Transferstatus = Status::where('name', 'Transferred')->first();
        $maintainstatus = Status::where('name', 'Maintainence Pending')->first();
        $data = collect([]);
        // $transfer = Transfer::where('handover_employee_id', $auth)->distinct()->pluck('product_id');
        // $issuance = Issuence::where('employee_id', $auth)->distinct()->pluck('product_id');
        $maintainance = MaintenanceUser::where('controller_id', $authid)->distinct()->pluck('product_id');
        // if ($transfer->isNotEmpty()) {
        //     foreach ($transfer as $transferItem) {
        //         $product_id = json_decode($transferItem);
        //         $transferData = Stock::whereIn('id', $product_id)
        //             ->where(function ($query) use ($Issuestatus, $Transferstatus) {
        //                 $query->where('status_available', $Issuestatus->id)
        //                     ->orWhere('status_available', $Transferstatus->id);
        //             })
        //             ->get();
        //         $data = $data->concat($transferData);
        //     }
        // }
        if ($maintainance->isNotEmpty()) {
            foreach ($maintainance as $maintain) {
                $product_id = json_decode($maintain);
                $maintainData = Stock::whereIn('id', $product_id)
                    ->where(function ($query) use ($maintainstatus) {
                        $query->where('status_available', $maintainstatus->id);
                    })
                    ->get();
                $data = $data->concat($maintainData);
            }
        }
        // if ($issuance->isNotEmpty()) {
        //     foreach ($issuance as $issuanceItem) {
        //         $product_id = json_decode($issuanceItem);
        //         $issuanceData = Stock::whereIn('id', $product_id)
        //             ->where(function ($query) use ($Issuestatus, $Transferstatus) {
        //                 $query->where('status_available', $Issuestatus->id)
        //                     ->orWhere('status_available', $Transferstatus->id);
        //             })
        //             ->get();
        //         $data = $data->concat($issuanceData);
        //     }
        // }
        // dd($data);
        $suppliers = MaintenanceSupplier::all();
        return view('Backend.Page.Maintenance.send', compact('data', 'reason', 'auth','suppliers'));
    }
    public function maintenance_save(Request $request)
    {
        // dd($request);
        $request->validate([
            'description'=>'required',
            'selectedAssets' => 'required|array',
            'user' => 'required|max:30',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);
        $randomNumber = 'MAIN' . str_pad(mt_rand(1111111, 9999999), 5, '0', STR_PAD_LEFT);
        $maintenance = Maintenance::Create([
            'product_id' => json_encode($request->selectedAssets),
            'status' => Status::where('name', 'Maintainence')->first()->id,
            'description' => $request->description,
            'maintenance_user_id' => $request->user,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'transaction_id'=> $randomNumber,
            'asset_number'=>0,  
            'supplier_id'=>0,
            'asset_price'=>0, 
        ]);
        foreach ($request->selectedAssets as $productId) {
            $stock = Stock::find($productId);
            $stock->update([
                'status_available' => Status::where('name', 'Maintainence')->first()->id,
            ]);
            $transferId = $maintenance->id;
            if ($stock) {
                TimelineHelper::logAction('Maintenance Product', $productId, $stock->asset_type_id, $stock->asset, null, null, null, null,null, null,$transferId,null,null,null);
            }
        }
        return back()->with('success', 'Asset in Under Maintenance');
    }
    public function edit(Maintenance $maintenance, $id)
    {
        $maintainance = Maintenance::find($id);
        // $asset = Asset::all();
        $supplier = Supplier::all();
        $status = Status::all();
        // $maintain = Maintenance::all();
        return view('Backend.Page.Maintenance.edit', compact('maintainance', 'supplier', 'status'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'product_id' => 'required',
            'asset_number' => 'required',
            'supplier_id' => 'required|max:30',
            'asset_price' => 'required'
        ]);
        $update = Maintenance::find($id);

        $update->product_id = $request->product_id;
        $update->asset_number = $request->asset_number;
        $update->status = $request->status;
        $update->asset_price = $request->asset_price;
        $update->supplier_id = $request->supplier_id;
        $update->start_date = $request->start_date;
        $update->end_date = $request->end_date;
        // // Check if request has assetType, if not, use the existing value
        // dd($update);
        // $update->asset_type_id = isset($request->assetType) ? $request->assetType : $update->asset_type_id;

        // // Check if request has supplier, if not, use the existing value
        // $update->supplier_id = isset($request->supplier) ? $request->supplier : $update->supplier_id;

        // // Check if request has assetName, if not, use the existing value
        // $update->asset_id = isset($request->asset) ? $request->asset : $update->asset_id;
        // $update->asset_number = $request->asset_number;
        // $update->start_date = $request->start_date;
        // $update->end_date = $request->end_date;

        // // Check if request has product_name, if not, use the existing value
        // $update->product_id = isset($request->product_name) ? $request->product_name : $update->product_id;

        if ($update->save()) {
            return redirect()->route('assets-maintenances')->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }



    public function destroy($id)
    {
        $data = Maintenance::find($id);
        if ($data) {
            $data->delete();
        }

        return response()->json(['success' => 'Record deleted successfully']);
    }
    public function maintenance_edit($id)
    {
        $maintenanceData = Maintenance::findOrFail($id);
        if (!$maintenanceData) {
            return response()->json(['error' => 'JSON Data not Found']);
        }
        return response()->json($maintenanceData);
    }
    public function getSuppliers($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        return response()->json($supplier);
    }
    public function getStatuses()
    {
        $status = Status::all();
        return view('Backend.Page.Maintenance.Receive.index', compact('status'));
    }

    public function statusupdate(Request $request, $productId)
    {
        $maintenance = Maintenance::where('product_id', $productId)->first();
        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance record not found'], 404);
        }
        $maintenance->update([
            'status' => $request->input('status'),
        ]);

        return response()->json(['message' => 'Data updated successfully']);
    }
    public function application(){
        $auth = Auth::id();
        $maintain = MaintenanceUser::where('controller_id',$auth)->get();
        $employee = [];
        $products = [];
        foreach ($maintain as $key => $value) {
            $id = json_decode($value->product_id);
            $employee[] = User::where('id',$value->perform_by_user)->first();
            foreach($id as $data){
            $products[] = Stock::where('id', $data)->first();
            }
        }
        return view('Backend.Page.Maintenance.application',compact('maintain','products','employee'));
    }
    public function markasreadapplication($id){
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $auth = Auth::id();
        $maintain = MaintenanceUser::where('controller_id',$auth)->get();
        $employee = [];
        $products = [];
        foreach ($maintain as $key => $value) {
            $id = json_decode($value->product_id);
            $employee[] = User::where('id',$value->perform_by_user)->first();
            foreach($id as $data){
            $products[] = Stock::where('id', $data)->first();
            }
        }
        return view('Backend.Page.Maintenance.application',compact('maintain','products','employee'));
    }
    public function report_maintenance($id)
    {
        $data = MaintenanceUser::find($id);
        $user = $data->perform_by_user;
        $manager = $data->controller_id;
        $mang = User::find($manager);
        $username = User::find($user);
        // dd($username);
        $product = $data->product_id;
        $retproduct = json_decode($product);
        $products=[];
        foreach($retproduct as $value){
        $products[] = Stock::find($value);
        }
        // dd($products);
        return view('Backend.Page.maintenance.all-application', compact('data', 'username', 'mang', 'products'));

    }
}
