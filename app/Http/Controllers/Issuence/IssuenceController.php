<?php

namespace App\Http\Controllers\Issuence;

use App\Helpers\TimelineHelper;
use App\Http\Controllers\Controller;
use App\Models\AssetRejection;
use App\Models\AssetReturn;
use App\Models\AssetType;
use App\Models\Issuence;
use App\Models\Location;
use App\Models\Role;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\IssuenceNotification;
use App\Notifications\TransferNotification;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IssuenceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employee = User::with('department', 'designation')->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')->first();
            return response()->json($employee);
        }
        $assettype = AssetType::all();
        $location = Location::all();
        return view('Backend.Page.Issuence.issuence', compact('assettype', 'location'));
    }
    public function getassetdetail(Request $request)
    {
        // dd($request->serialNumber);
        if ($request->ajax()) {
            $statusinstock = Status::where('name', 'Pending')->first();
            $statuspending = Status::where('name', 'Instock')->first();
            // dd($request);
            $response = Stock::with('brand', 'brandmodel', 'asset_type')
                ->where('serial_number', $request->serialNumber)
                ->orWhere('product_number', $request->serialNumber)
                ->where(function ($query) use ($statusinstock, $statuspending) {
                    $query->where('status_available', $statuspending->id)
                        ->orWhere('status_available', $statusinstock->id);
                })
                ->first();
            return response()->json($response);
        }
    }
    public function getchangecard(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        $result = Stock::where('id', $requestData['cardId'])->with('brand', 'brandmodel')->get();
        // dd($result);
        return response()->json($result);
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Start a database transaction
        try {
            $request->validate([
                'employeeId' => 'required',
                'cardId' => 'required',
                'due_date' => 'required',
                'description' => 'nullable',
                'location_id' => 'required',
                'sublocation_id' => 'required',
            ]);
            $stock = Stock::where('id', $request->cardId)->first();
            // dd($stock->asset_type_id);
            $user = User::where('employee_id', $request->employeeId)->first();
            if (!$user) {
                return back()->with('error', 'User not found.');
            }
            $managerUser = User::where('role_id', 3)->where('department_id', $user->department_id)->first();
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
            $issuance = Issuence::create([
                'employee_id' => $request->employeeId,
                'asset_type_id' => $stock->asset_type_id,
                'asset_id' => $stock->asset,
                'product_id' => json_encode($request->cardId),
                'description' => $request->description,
                'issuing_time_date' => $dateTime,
                'due_date' => $request->due_date,
                'location_id' => $request->location_id,
                'sub_location_id' => $request->sublocation_id,
                'employee_manager_id' => $managerUser ? $managerUser->id : null,
            ]);
            $productId = $request->cardId;
            foreach ($productId as $product) {
                TimelineHelper::logAction('Product Issued', $product, $stock->asset_type_id, $stock->asset, $issuance->id, $user->id);
            }
            DB::commit(); // Commit the transaction

            $assetcontroller = Role::where('name', 'Asset Controller')->first();
            $assetmanager = User::where('role_id', $assetcontroller->id)
                ->where('department_id', $user->department_id)
                ->first();
            $user->notify(new IssuenceNotification($user));
            if ($managerUser) {
                $managerUser->notify(new IssuenceNotification($managerUser));
            }
            if ($assetmanager) {
                $assetmanager->notify(new IssuenceNotification($assetmanager));
            }
            $stock = Stock::where('id', $request->cardId)->first();
            if ($stock) {
                $stock->update(['status_available' => Status::where('name', 'Issued')->first()->id]);
            }
            $data = [
                'name' => $request->first_name . ' ' . $request->last_name,
                'company_name' => 'IT-Asset',
                'employee_id' => $request->employee_id,
                'email' => $request->email,
                'product_name' => $stock->product_info . ' ' . $stock->assetmain->name,
                'product_serial' => $stock->serial_number,
                'product_time' => $issuance->created_at,
            ];
            $users['to'] = $user->email;
            Mail::send('Backend.Auth.mail.issuance_mail', $data, function ($message) use ($users) {
                $message->from('itasset@svamart.com', 'itasset@svamart.com');
                $message->to($users['to']);
                $message->subject('Asset Issued Successfully.');
            });
            return back()->with('success', 'Asset Issued!');
        } catch (QueryException $e) {
            DB::rollback(); // Rollback the transaction in case of an error
            return back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an error
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function markasread($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        return view('Backend.Page.Issuence.accept', compact('products', 'issuedata'));
    }
    public function markasreadmanager($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->orderByDesc('created_at')
            ->first();
        $transferdata = Transfer::where('employee_id', $issuedata->employee_id)->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::where('employee_id', $issuedata->employee_id)->first();
        $transferuser = User::where('employee_id', $transferdata->handover_employee_id ?? '')->first();
        $users = DB::table('notifications')->Where('type', 'App\Notifications\TransferNotification')->first();
        return view('Backend.Page.Issuence.accept', compact('products', 'issuedata', 'user', 'users', 'transferuser'));
    }
    public function markasreadcontroller($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return back();
    }
    public function AssetAccept($id)
    {
        if (Auth::user()->role_id == 2) {
            $status = Status::where('name', 'Accepted by User')->orWhere('name', 'Rejected')->first();
            Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
            return redirect()->route('user-dashboard')->with('success', 'Asset Alloted!');
        } else {
            $status = Status::where('name', 'Transferred')->first();
            Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
            return redirect()->route('user-dashboard')->with('success', 'Asset Alloted!');
        }
    }
    public function AssetAcceptmanager($id)
    {
        $status = Status::where('name', 'Transferred by Manager')->first();
        Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
        $user = Auth::user();
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assetmanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $user->department_id)->first();
        $assetmanager->notify(new TransferNotification($assetmanager));
        return redirect()->route('user-dashboard')->with('success', 'Asset Transferred!');
    }
    public function showAll()
    {
        $issuences = DB::table('issuences')
            ->select('issuences.*', 'stocks.*')
            ->join('stocks', 'issuences.product_id', 'like', DB::raw('CONCAT("%", stocks.id, "%")'))
            ->get();
        return view('Backend.Page.Issuence.all-issuence', compact('issuences'));
    }
    public function AssetAcceptdetail($id)
    {
        $data = Stock::find($id);
        return view('Backend.Page.Issuence.accept-detail', compact('data'));
    }
    public function rejection(Request $request)
    {
        $request->validate([
            'reason' => 'required',
        ]);
        $authuser = Auth::user()->id;
        AssetRejection::create([
            'rejection_by_user' => $authuser,
            'reason' => $request->reason,
        ]);
        $status = Status::where('name', 'Rejected')->first();
        Stock::updateOrCreate(['id' => $request->productIdToReject], ['status_available' => $status->id]);
        return back()->with('success', 'Asset Rejected!');
    }
    public function employee_issue()
    {
        $id = 2;
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        return view('Backend.Page.Employee.issue_request', compact('products', 'issuedata'));
    }
    public function employee_all_issue()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $data = Issuence::where('employee_id', $user->employee_id)->get();
            // dd($data);
            return view('Backend.Page.Employee.all_issue', compact('data'));
        } else {
            return redirect()->back();
        }
    }
    public function all_transfer()
    {
        if (Auth::check()) {
            $transfer = Auth::user();
            // $return = AssetReturn::where('product_id', $transfer->employee_id)->get();
            $return = AssetReturn::when(isset($transfer->product_id), function ($query) use ($transfer) {
                return $query->where('product_id', $transfer->employee_id);
            })
                ->get();
            return view('Backend.Page.Employee.all_transfer', compact('return'));
        } else {
            return redirect()->back();
        }
    }
    public function updatestockstatus(Request $request)
    {
        $assetId = $request->input('asset_id');
        $newStatus = $request->input('new_status');
        $asset = Stock::where('serial_number', $assetId)->first();
        $product = Stock::where('product_number', $assetId)->first();

        if ($asset) {
            $updateResult = $asset->update(['status_available' => $newStatus]);

            if ($updateResult) {
                sleep(3);
                return response()->json(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to update status']);
            }
        }

        if ($product) {
            $updateResult = $product->update(['status_available' => $newStatus]);

            if ($updateResult) {
                sleep(3);
                return response()->json(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to update status']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Asset or product not found']);
    }
}
