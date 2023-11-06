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
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function index()
    {
        $auth = Auth::user()->employee_id;
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
            return view('Backend.Page.Transfer.return', compact('data'));
        } else {
            return view('Backend.Page.Transfer.return');
        }
    }

    public function submit(Request $request)
    {
        // dd($request);
        // try {
            $request->validate([
                'selectedAssets' => 'required', // Ensure that cardId is an array
                'description' => 'required',
            ]);
            $auth = Auth::user();
            $role = Role::where('name', 'Manager')->first();
            $user = User::where('role_id', $role->id)
                ->where('department_id', $auth->department_id)
                ->first();
            $randomNumber = 'RETU' . str_pad(mt_rand(1111111, 9999999), 5, '0', STR_PAD_LEFT);
            $return = AssetReturn::create([
                'product_id' => json_encode($request->selectedAssets),
                'reason' => $request->description,
                'return_by_user' => $auth->id,
                'manager_user_id' => $user->id,
                'return_transaction_code' => $randomNumber,
            ]);
            $status = Status::where('name', 'Returned by User')->first();
            foreach ($request->selectedAssets as $cardId) {
                $product = Stock::where('id', $cardId)->first();
                $product->update(['status_available' => $status->id]);
                TimelineHelper::logAction('Asset Returned', $cardId, $product->asset_type_id, $product->asset, null, null, null, null, null, null, null, null, $return->id, $auth->id);
            }
            $assetcontroller = Role::where('name', 'Asset Controller')->first();
            $assetmanager = User::where('role_id', $assetcontroller->id)
                ->where('department_id', $auth->department_id)
                ->first();
            if ($user) {
                $user->notify(new ReturnNotification($user));
                DB::table('notifications')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
                    ->update(['return_id' => $return->id]);
            }
            if ($assetmanager) {
                $assetmanager->notify(new ReturnNotification($assetmanager));
                DB::table('notifications')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
                    ->update(['return_id' => $return->id]);
            }
            return back()->with('success', 'Asset Returned.');
        // } catch (Exception $e) {
        //     return back()->with('error', 'An error occurred while processing your request.');
        // }
    }
    public function allreturn(){
        $data = AssetReturn::all();
        return view('Backend.Page.Transfer.all-return',compact('data'));
    }
    public function report_return($id){
        $data = AssetReturn::find($id);
        $user = $data->return_by_user;
        $manager = $data->manager_user_id;
        $mang = User::find($manager);
        $username = User::find($user);
        // dd($username);
        $product = $data->product_id;
        $retproduct = json_decode($product);
        $products = Stock::find($retproduct);
        return view('Backend.Page.Transfer.all-return-report',compact('data','username','mang','products'));

    }
}
