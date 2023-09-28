<?php

namespace App\Http\Controllers\Transfer;

use App\Helpers\TimelineHelper;
use App\Http\Controllers\Controller;
use App\Models\AssetReturn;
use App\Models\Issuence;
use App\Models\Role;
use App\Models\Status;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ReturnNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function index()
    {
        $auth = Auth::user()->employee_id;
        $issue = Issuence::where('employee_id', $auth)->distinct()->pluck('product_id');
        $Issuestatus = Status::where('name', 'Accepted by User')->first();
        $Transferstatus = Status::where('name', 'Transferred by Manager')->first();
        $data = []; // Define $data as an empty array

        if ($issue != '') {
            foreach ($issue as $issue) {
                $product_id = json_decode($issue);
                $data = Stock::whereIn('id', $product_id)
                    ->where(function ($query) use ($Issuestatus, $Transferstatus) {
                        $query->where('status_available', $Issuestatus->id)
                            ->orWhere('status_available', $Transferstatus->id);
                    })
                    ->get();
            }
            return view('Backend.Page.Transfer.return', compact('data'));
        } else {
            return view('Backend.Page.Transfer.return');
        }
    }

    public function submit(Request $request)
    {
        try {
            $request->validate([
                'cardId' => 'required', // Ensure that cardId is an array
                'description' => 'required',
            ]);
            $auth = Auth::user();
            $cardIds = $request->input('cardId');
            $return = AssetReturn::create([
                'product_id' => json_encode($cardIds),
                'reason' => $request->description,
                'return_by_user' => $auth->id,
            ]);
            $status = Status::where('name', 'Returned by User')->first();
            Stock::whereIn('id', $cardIds)->update(['status_available' => $status->id]);
            foreach ($cardIds as $cardId) {
                $product = Stock::where('id',$cardId)->first();
                TimelineHelper::logAction('Asset Returned', $cardId, $product->asset_type_id, $product->asset, null, null, null, null, null, null, null, null, $return->id, $auth->id);
            }
            $role = Role::where('name', 'Manager')->first();
            $user = User::where('role_id', $role->id)
                ->where('department_id', $auth->department_id)
                ->first();
            $assetcontroller = Role::where('name', 'Asset Controller')->first();
            $assetmanager = User::where('role_id', $assetcontroller->id)
                ->where('department_id', $auth->department_id)
                ->first();
            if ($user) {
                $user->notify(new ReturnNotification($user));
            }
            if ($assetmanager) {
                $assetmanager->notify(new ReturnNotification($assetmanager));
            }
            return back()->with('success', 'Asset Returned.');
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while processing your request.');
        }
    }
}
