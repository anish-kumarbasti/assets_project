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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employee = User::with('department', 'designation')
                ->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
                ->first() ?? null;
            $issue = Issuence::where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
                ->get() ?? null;
            $result = [];
            if ($employee && $issue) {
                $result['employee'] = $employee;
                foreach($issue as $product){
                $productid = json_decode($product->product_id);
                $products = Stock::whereIn('id', $productid)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
                }
                $result['products'] = $products;
            } else {
                $result['employee'] = null;
                $result['products'] = [];
            }
            // Now, $result contains both the employee and associated products.
            return response()->json($result);
        }
        $reason = TransferReason::all();
   return view('Backend.Page.Transfer.transfer', compact('reason'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Start a database transaction
        try {
            $request->validate([
                'employeeId' => 'required|exists:users,employee_id',
                'reason' => 'required|integer|exists:transfer_reasons,id',
                'handoverId' => 'required|exists:users,employee_id',
                'description' => 'required',
            ]);
            $user = User::where('employee_id', $request->employeeId)->first();
            $managerUser = User::where('role_id', 3)
                ->where('department_id', $user->department_id)->first();
            $handover = User::where('employee_id', $request->handoverId)->first();
            $managertoUser = User::where('role_id', 3)
            ->where('department_id', $handover->department_id)->first();
            $transfer = Transfer::create([
                'employee_id' => $request->employeeId,
                'product_id' => json_encode($request->cardId),
                'reason_id' => $request->reason,
                'handover_employee_id' => $request->handoverId,
                'description' => $request->description,
                'handover_manager_id'=>$managertoUser->id,
                'employee_manager_id'=>$managerUser->id,
            ]);
            foreach ($request->cardId as $productId) {
                $stock = Stock::find($productId);
                // dd($stock);
                $transferId=$transfer->id;
                if ($stock) {
                    TimelineHelper::logAction('Product Transferred', $productId, $stock->asset_type_id, $stock->asset, null,null,$transferId, $user->id);
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
            }

            if ($assetmanager != null) {
                $assetmanager->notify(new TransferNotification($assetmanager));
            }
            if ($managertoUser != null) {
                $managertoUser->notify(new TransferNotification($managertoUser));
            }

            if ($assettomanager != null) {
                $assettomanager->notify(new TransferNotification($assettomanager));
            }

            $stock = Stock::where('id', $request->cardId)->first();
            $stock->update([
                'status_available' => Status::where('name', 'Transfer Pending')->first()->id,
            ]);
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

        // $transfers = Transfer::all();
        return view('Backend.Page.Transfer.all-transfer', compact('transfers'));
    }
}
