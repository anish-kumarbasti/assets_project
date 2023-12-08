<?php

namespace App\Http\Controllers\Transfer;

use App\Helpers\TimelineHelper;
use App\Http\Controllers\Controller;
use App\Models\Issuence;
use App\Models\Role;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Transfer;
use App\Models\TransferReason;
use App\Models\User;
use App\Notifications\TransferNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index(Request $request)
    {
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
        return view('Backend.Page.Transfer.transfer', compact('data', 'reason', 'auth'));
    }

    public function store(Request $request)
    {
        // try {
        $request->validate([
            'employeeId' => 'required|exists:users,employee_id',
            'reason' => 'required|integer|exists:transfer_reasons,id',
            'handoverId' => 'required|exists:users,employee_id',
            'description' => 'required',
            'selectedAssets' => 'required|array',
        ]);
        $user = User::where('employee_id', $request->employeeId)->first();
        $managerUser = User::where('role_id', 3)
            ->where('department_id', $user->department_id)->first();
        $handover = User::where('employee_id', $request->handoverId)->first();
        $managertoUser = User::where('role_id', 3)
            ->where('department_id', $handover->department_id)->first();
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assetmanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $user->department_id)->first() ?? null;
        $assettomanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $handover->department_id)->first() ?? null;
        $randomNumber = 'TRAN' . str_pad(mt_rand(1111111, 9999999), 5, '0', STR_PAD_LEFT);
        $transfer = Transfer::create([
            'employee_id' => $request->employeeId,
            'product_id' => json_encode($request->selectedAssets),
            'reason_id' => $request->reason,
            'handover_employee_id' => $request->handoverId,
            'description' => $request->description,
            'handover_manager_id' => $managertoUser->id,
            'employee_manager_id' => $managerUser->id,
            'transfers_transaction_code' => $randomNumber,
        ]);
        foreach ($request->selectedAssets as $productId) {
            $stock = Stock::find($productId);
            $stock->update([
                'status_available' => Status::where('name', 'Transfer Pending')->first()->id,
            ]);
            $transferId = $transfer->id;
            if ($stock) {
                TimelineHelper::logAction('Product Transferred', $productId, $stock->asset_type_id, $stock->asset, null, null, $transferId, $user->id);
            }
        }
        if ($assetmanager->employee_id == $request->handoverId || $assettomanager->employee_id == $request->handoverId) {
            $managertoUser->notify(new TransferNotification($managertoUser));
            $count = 0;
            $a = [];
            $lastFourRecords = DB::table('notifications')
                ->orderBy('created_at', 'desc')
                ->take(1)
                ->update(['transfer_id' => $transfer->id]);
        } elseif ($managerUser == $managertoUser) {
            $managerUser->notify(new TransferNotification($managerUser));
            $assetmanager->notify(new TransferNotification($assetmanager));
            $count = 0;
            $a = [];
            $lastFourRecords = DB::table('notifications')
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->update(['transfer_id' => $transfer->id]);
        } else {
            $managerUser->notify(new TransferNotification($managerUser));
            $assetmanager->notify(new TransferNotification($assetmanager));
            $managertoUser->notify(new TransferNotification($managertoUser));
            $count = 0;
            $a = [];
            $lastFourRecords = DB::table('notifications')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->update(['transfer_id' => $transfer->id]);
        }
        return back()->with('success', 'Asset Transferred successfully.');
        // } catch (QueryException $e) {
        //     DB::rollback(); // Rollback the transaction in case of an error
        //     return back()->with('error', 'Database error: ' . $e->getMessage());
        // } catch (\Exception $e) {
        //     DB::rollback(); // Rollback the transaction in case of an error
        //     return back()->with('error', 'An error occurred: ' . $e->getMessage());
        // }
    }

    public function showAll()
    {
        $transfers = Transfer::with('user')->get();
        $product = [];
        foreach ($transfers as $key => $data) {
            $id = json_decode($data->product_id);
            $product[] = Stock::where('id', $id)->first();
        }
        return view('Backend.Page.Transfer.all-transfer', compact('transfers', 'product'));
    }

    public function showtransfer(Request $request, $id)
    {
        $transfer = Transfer::find($id);
        $emp = $transfer->employee_id;
        $emptransfer = $transfer->handover_employee_id;
        $find = User::where('employee_id', $emp)->first();
        // dd($find);
        $find2 = User::where('employee_id', $emptransfer)->first();
        // dd($find2);
        $handovermanager = $transfer->handover_manager_id;
        $user = User::find($handovermanager);
        $product = $transfer->product_id;
        $products = json_decode($product);
        $productdata = Stock::find($products);
        $request->session()->put('id', $id);
        return view('Backend.Page.Transfer.showtransfer', compact('transfer', 'user', 'productdata', 'find2', 'find', 'id'));
    }
    public function print_transfer($id)
    {
        $transfer = Transfer::find($id);
        // dd($transfer);
        $emp = $transfer->employee_id;
        $emptransfer = $transfer->handover_employee_id;
        $find = User::where('employee_id', $emp)->first();
        $find2 = User::where('employee_id', $emptransfer)->first();
        $handovermanager = $transfer->handover_manager_id;
        $user = User::where('id', $handovermanager)->first();
        $empmngid = $transfer->employee_manager_id;
        $employeemanid = User::where('id', $empmngid)->first();
        $product = $transfer->product_id;
        $products = json_decode($product);
        $productdata = Stock::find($products);

        $assetcontrollerrol = Role::where('name', 'Asset Controller')->first();
        $assetcontroller = User::where('role_id', $assetcontrollerrol->id)
            ->where('department_id', $find->department_id)->first() ?? null;
        $assetcontroller1 = User::where('role_id', $assetcontrollerrol->id)->where('department_id', $find2->department_id)->first() ?? null;
        return view('Backend.Page.Transfer.transfer-print', compact('transfer', 'assetcontroller', 'assetcontroller1', 'user', 'productdata', 'employeemanid', 'find2', 'find'));
    }
}
