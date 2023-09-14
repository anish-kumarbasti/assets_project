<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\TransferReason;
use Illuminate\Http\Request;

class TransferReasonController extends Controller
{
    public function index()
    {
        $transferReasons = TransferReason::all();
        return view('Backend.Page.Master.transfer', compact('transferReasons'));
    }

    public function create()
    {
        return view('transfer-reasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        TransferReason::create([
            'reason' => $request->input('reason'),
            'status' => true, // Assuming you want to set the status to true by default
        ]);

        return redirect()->route('transfer-reasons.index')->with('success', 'Transfer reason created successfully');
    }

    public function edit(TransferReason $transferReason)
    {
        return view('Backend.Page.Master.transfer', compact('transferReason'));
    }

    public function update(Request $request, TransferReason $transferReason)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $transferReason->update([
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('transfer-reasons.index')->with('success', 'Transfer reason updated successfully');
    }

    public function destroy(TransferReason $transferReason)
    {
        $transferReason->delete();
        return response()->json(['success' => true]);    
    }
    public function updateStatus(Request $request, TransferReason $reason)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($reason->status == 1) {
            TransferReason::where('id', $reason->id)->update([
                'status' => 0
            ]);
        } else {
            TransferReason::where('id', $reason->id)->update([
                'status' => 1
            ]);
        }
        return response()->json(['success' => true]);;
    }
}
