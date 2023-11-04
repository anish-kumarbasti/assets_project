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
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user()->employee_id;
        $reason = TransferReason::all();
        $issue = Issuence::where('employee_id', $auth)->distinct()->pluck('product_id');
        $Issuestatus = Status::where('name', 'Accepted by User')->first();
        $Transferstatus = Status::where('name', 'Transferred by Manager')->first();
        $data = collect([]);

        if ($issue != '') {
            foreach ($issue as $issue) {
                $product_id = json_decode($issue);
                $datas = Stock::whereIn('id', $product_id)
                    ->where(function ($query) use ($Issuestatus, $Transferstatus) {
                        $query->where('status_available', $Issuestatus->id)
                            ->orWhere('status_available', $Transferstatus->id);
                    })
                    ->get();
                $data = $data->concat($datas);
            }
            return view('Backend.Page.Transfer.transfer', compact('data', 'reason', 'auth'));
        }

        return view('Backend.Page.Transfer.transfer', compact('reason', 'data', 'auth'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction(); // Start a database transaction
        try {
            $request->validate([
                'employeeId' => 'required|exists:users,employee_id',
                'reason' => 'required|integer|exists:transfer_reasons,id',
                'handoverId' => 'required|exists:users,employee_id',
                'description' => 'required',
            ]);
            // dd($request);
            $user = User::where('employee_id', $request->employeeId)->first();
            $managerUser = User::where('role_id', 3)
                ->where('department_id', $user->department_id)->first();
            $handover = User::where('employee_id', $request->handoverId)->first();
            $managertoUser = User::where('role_id', 3)
                ->where('department_id', $handover->department_id)->first();
            $randomNumber = 'TRAN' . str_pad(mt_rand(1111111, 9999999), 5, '0', STR_PAD_LEFT);
            $transfer = Transfer::create([
                'employee_id' => $request->employeeId,
                'product_id' => json_encode($request->selectedCardIds),
                'reason_id' => $request->reason,
                'handover_employee_id' => $request->handoverId,
                'description' => $request->description,
                'handover_manager_id' => $managertoUser->id,
                'employee_manager_id' => $managerUser->id,
                'transfers_transaction_code'=> $randomNumber,
            ]);
            foreach ($request->selectedCardIds as $productId) {
                $stock = Stock::find($productId);
                $stock->update([
                    'status_available' => Status::where('name', 'Transfer Pending')->first()->id,
                ]);
                $transferId = $transfer->id;
                if ($stock) {
                    TimelineHelper::logAction('Product Transferred', $productId, $stock->asset_type_id, $stock->asset, null, null, $transferId, $user->id);
                }
            }
            DB::commit();
            $assetcontroller = Role::where('name', 'Asset Controller')->first();
            $assetmanager = User::where('role_id', $assetcontroller->id)
                ->where('department_id', $user->department_id)->first() ?? null;
            $assettomanager = User::where('role_id', $assetcontroller->id)
                ->where('department_id', $handover->department_id)->first() ?? null;
            if ($managerUser != null) {
                $managerUser->notify(new TransferNotification($managerUser));
                DB::table('notifications')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
                    ->update(['transfer_id' => $transfer->id]);
            }
            if ($assetmanager != null) {
                $assetmanager->notify(new TransferNotification($assetmanager));
                DB::table('notifications')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
                    ->update(['transfer_id' => $transfer->id]);
            }
            if ($managertoUser != null) {
                $managertoUser->notify(new TransferNotification($managertoUser));
                DB::table('notifications')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
                    ->update(['transfer_id' => $transfer->id]);
            }
            if ($assettomanager != null) {
                $assettomanager->notify(new TransferNotification($assettomanager));
                DB::table('notifications')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
                    ->update(['transfer_id' => $transfer->id]);
            }
            return back()->with('success', 'Asset Transferred successfully.');
        } catch (QueryException $e) {
            DB::rollback(); // Rollback the transaction in case of an error
            return back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an error
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function showAll()
    {
        $transfers = Transfer::with('user')->get();
        $product = '';
        foreach ($transfers as $data) {
            $id = json_decode($data->product_id);
            $product = Stock::where('id', $id)->get();
        }
        return view('Backend.Page.Transfer.all-transfer', compact('transfers', 'product'));
    }
}
