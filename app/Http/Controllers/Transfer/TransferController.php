<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Issuence;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Transfer;
use App\Models\TransferReason;
use App\Models\User;
use App\Notifications\TransferNotification;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employee = User::with('department', 'designation')
                ->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
                ->first() ?? null;

            $issue = Issuence::where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
                ->first() ?? null;

            $result = [];
            if ($employee && $issue) {
                $result['employee'] = $employee;
                $productIds = json_decode($issue->product_id);
                $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
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
        $request->validate([
            'employeeId' => 'required|exists:users,employee_id',
            'reason' => 'required|integer|exists:transfer_reasons,id',
            'handoverId' => 'required|exists:users,employee_id',
            'description' => 'required',
        ]);

        Transfer::create([
            'employee_id' => $request->employeeId,
            'product_id' => json_encode($request->cardId),
            'reason_id' => $request->reason,
            'handover_employee_id' => $request->handoverId,
            'description' => $request->description,
        ]);
        $user = User::where('employee_id', $request->employeeId)->first();
        $managerUser = User::where('role_id', 3)
            ->where('department_id', $user->department_id)->first();
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assetmanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $user->department_id)->first() ?? null;
        if ($managerUser != null) {
            $managerUser->notify(new TransferNotification($managerUser));
        }
        if ($assetmanager != null) {
            $assetmanager->notify(new TransferNotification($assetmanager));
        }
        return back()->with('success', 'Asset Transfered successfully.');
    }
    public function showAll()
{
    $transfers = Transfer::with('employee', 'handoverEmployee', 'reason', 'products')->get();
    return view('Backend.Page.Transfer.all-transfer', compact('transfers'));
}
}
