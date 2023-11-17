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
    public function trash()
    {
        $transferReasons = TransferReason::onlyTrashed()->get();
        return view('Backend.Page.Master.trash', compact('transferReasons'));
    }
    public function restore($id)
    {
        $transferReasons = TransferReason::withTrashed()->findOrFail($id);
        // dd($id);
        if (!empty($transferReasons)) {
            $transferReasons->restore();
        }
        TransferReason::find($id)->update(['status' => true]);
        return redirect()->route('transfer-reasons.index')->with('success', 'Brand Restore Successfully');
    }
    public function forceDelete($id)
    {
        $transferReasons = TransferReason::withTrashed()->find($id);
        $transferReasons->forceDelete();
        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('transfer-reasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:transfer_reasons,reason,except,id',
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
        if ($transferReason->status == true) {
            TransferReason::find($transferReason->id)->update(['status' => false]);
            $referencesExist = $transferReason->transfers()->exists();
            if ($referencesExist) {
                return response()->json(['success' => false, 'message' => 'Reason is referenced in one or more tables and cannot be deleted.']);
            }
            $transferReason->delete();
            return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
        } else {
            $referencesExist = $transferReason->transfers()->exists();
            if ($referencesExist) {
                return response()->json(['success' => false, 'message' => 'Supplier is referenced in one or more tables and cannot be deleted.']);
            }
            $transferReason->delete();
            return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
        }
    }
    public function updateStatus(Request $request, TransferReason $reason)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($reason->status == 1) {
            TransferReason::where('id', $reason->id)->update([
                'status' => 0,
            ]);
        } else {
            TransferReason::where('id', $reason->id)->update([
                'status' => 1,
            ]);
        }
        return response()->json(['success' => true]);
    }
}
