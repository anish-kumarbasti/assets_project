<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Issuence;
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
        if($request->ajax()){
        $employee = User::with('department', 'designation')
            ->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
            ->first() ?? null;

        $issue = Issuence::with('allStock')
            ->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
            ->first() ?? null;

        $result = [];
        if ($employee && $issue) {
            $result['employee'] = $employee;

            // Decode the JSON product_id field from Issuence model
            $productIds = json_decode($issue->product_id);

            // Retrieve the products from the Stock model where any ID matches the product_ids
            $products = Stock::whereIn('id', $productIds)->with('brand','brandmodel','asset_type','getsupplier')->get();

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
            'employee_id'=>$request->employeeId,
            'product_id'=>json_encode($request->cardId),
            'reason_id'=>$request->reason,
            'handover_employee_id'=>$request->handoverId,
            'description'=>$request->description,
        ]);
        $user = User::where('employee_id',$request->employeeId)->first();
        $user->notify(new TransferNotification($user));
        return back()->with('success', 'Asset Transfered successfully.');
    }
}
