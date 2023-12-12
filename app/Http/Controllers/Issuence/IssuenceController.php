<?php

namespace App\Http\Controllers\Issuence;

use App\Helpers\TimelineHelper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
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
use App\Notifications\IssuenceAcceptNotification;
use App\Notifications\IssuenceNotification;
use App\Notifications\TransferAcceptNotification;
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
        $asset = Asset::all();
        return view('Backend.Page.Issuence.issuence', compact('assettype', 'location', 'asset'));
    }
    public function getassetdetail(Request $request)
    {
        // dd($request->serialNumber);
        if ($request->ajax()) {
            $statusinstock = Status::where('name', 'Pending')->first();
            $statuspending = Status::where('name', 'Instock')->first();
            // dd($request);
            $response = Stock::with('brand', 'brandmodel', 'assetmain', 'asset_type', 'getsupplier')
                ->where('product_number', $request->serialNumber)
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
        // dd($request->all());
        try {
            $request->validate([
                'employeeId' => 'required',
                'selectedAssets' => 'required|array',
                'selectedAssets.*' => 'required',
                'due_date' => 'required',
                'description' => 'nullable',
                'location_id' => 'required',
                'sublocation_id' => 'required',
            ]);
            $user = User::where('employee_id', $request->employeeId)->first();
            if (!$user) {
                return back()->with('error', 'User not found.');
            }
            // dd($user);
            $managerUser = User::where('role_id', 3)->where('department_id', $user->department_id)->first();
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
            $selectedStocks = Stock::whereIn('id', $request->selectedAssets)->get();
            $randomNumber = 'ISU' . str_pad(mt_rand(1111111, 9999999), 5, '0', STR_PAD_LEFT);
            $issuance = Issuence::create([
                'employee_id' => $request->employeeId,
                'asset_type_id' => $selectedStocks->first()->asset_type_id,
                'asset_id' => $selectedStocks->first()->asset,
                'product_id' => json_encode($request->selectedAssets),
                'description' => $request->description,
                'issuing_time_date' => $dateTime,
                'due_date' => $request->due_date,
                'location_id' => $request->location_id,
                'sub_location_id' => $request->sublocation_id,
                'employee_manager_id' => $managerUser ? $managerUser->id : null,
                'transaction_code' => $randomNumber,
            ]);
            $selectedAssets = $request->selectedAssets;
            $value = [];
            foreach ($selectedAssets as $selectedAsset) {
                $value = Stock::where('id', $selectedAsset)->get();
                foreach ($value as $asset) {
                    TimelineHelper::logAction('Product Issued', $selectedAsset, $asset->asset_type_id, $asset->asset, $issuance->id, $user->id);
                }
            }
            $selectedStocks->each(function ($stock) {
                $stock->update(['status_available' => Status::where('name', 'Issue Pending')->first()->id]);
            });
            // dd($selectedStocks);
            $assetcontroller = Role::where('name', 'Asset Controller')->first();
            $assetmanager = User::where('role_id', $assetcontroller->id)
                ->where('department_id', $user->department_id)
                ->first();
            $notification = new IssuenceNotification($user);
            $user->notify($notification);
            // dd($notification);
            DB::table('notifications')
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->update(['issuance_id' => $issuance->id]);

            foreach ($value as $products) {
                $data = [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'company_name' => 'IT-Asset',
                    'employee_id' => $user->employee_id,
                    'email' => $user->email,
                    'product_name' => $products->product_info . ' ' . $products->assetmain->name,
                    'product_serial' => $products->serial_number,
                    'product_time' => $issuance->created_at,
                ];
                $users['to'] = $user->email;
                Mail::send('Backend.Auth.mail.issuance_mail', $data, function ($message) use ($users) {
                    $message->from('itasset@svamart.com', 'itasset@svamart.com');
                    $message->to($users['to']);
                    $message->subject('Asset Issued Successfully.');
                });
            }
            return back()->with('success', 'Asset Issued!');
        } catch (QueryException $e) {
            return back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function markasread($id, $typeId)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }

        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;

        $issuedata = Issuence::where('id', $typeId)
            ->where('employee_id', $user)->get();
        // dd($issuedata);
        $productIds = [];
        $createdDates = [];
        $userdetail = [];
        $transactioncode = [];
        $description = [];
        $datatime = '';
        foreach ($issuedata as $issuedatas) {
            $productIds[] = json_decode($issuedatas->product_id);
            $createdDates[] = $issuedatas->created_at;
            $userdetail[] = $issuedatas->employee_id;
            $transactioncode = $issuedatas->transaction_code;
            $description = $issuedatas->description;
            $datatime = $issuedatas->issuing_time_date;
        }
        $selectedAssetIds = collect($productIds)->flatten()->unique()->toArray();
        $products = Stock::whereIn('id', $selectedAssetIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get()->sortByDesc('status_available');
        // dd($transactioncode);
        $user = User::where('employee_id', $userdetail)->first();
        $users = DB::table('notifications')->where('type', 'App\Notifications\TransferNotification')->first();
        return view('Backend.Page.Issuence.accept', compact('products', 'createdDates', 'user', 'users', 'transactioncode', 'description', 'datatime'));
    }
    public function markasreadTransfer($id, $typeId)
    {
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $transfer = Transfer::where('id', $typeId)->first();
        if ($transfer->handover_employee_id == $user) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
            $issuedata = Transfer::where('id', $typeId)->where('handover_employee_id', $user)
                ->orWhere('employee_manager_id', $manager)->get();
            $productIds = [];
            $createdDates = [];
            $userdetail = [];
            $transactioncode = [];
            $description = [];
            foreach ($issuedata as $issuedatas) {
                $productIds[] = json_decode($issuedatas->product_id);
                $createdDates[] = $issuedatas->created_at;
                $userdetail[] = $issuedatas->employee_id;
                $transactioncode = $issuedatas->transfers_transaction_code;
                $description = $issuedatas->description;
            }
            $products = [];
            foreach ($productIds as $productId) {
                $products = Stock::whereIn('id', $productId)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
            }
            $user = User::where('employee_id', $userdetail)->first();
            return view('Backend.Page.Issuence.accept-transfer-user', compact('products', 'createdDates', 'user', 'transactioncode', 'description'));
        } else {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
            $user = Auth::user()->employee_id;
            $manager = Auth::user()->id;
            $transferdata = [];
            // dd($manager);
            $checkdata = Transfer::where('id', $typeId)->orderBy('created_at', 'desc')->get();
            if ($checkdata[0]->handover_manager_id == $checkdata[0]->employee_manager_id) {
                $transferdata = Transfer::where('id', $typeId)->where('handover_manager_id', $manager)->orderBy('created_at', 'desc')->get();
                // dd($transferdata);
            } else {
                $transferdata = Transfer::where('id', $typeId)->orderBy('created_at', 'desc')->get();
            }
            $productIds = [];
            $createdDates = [];
            $userdetail = [];
            $transactioncode = '';
            $description = '';
            $employee = '';
            $handempl = [];
            $handoveruserdetail = [];
            foreach ($transferdata as $issuedatas) {
                $productIds[] = json_decode($issuedatas->product_id);
                $createdDates[] = $issuedatas->created_at;
                $userdetail[] = $issuedatas->employee_id;
                $handoveruserdetail = $issuedatas->handover_employee_id;
                $transactioncode = $issuedatas->transfers_transaction_code;
                $description = $issuedatas->description;
                $handempl = $issuedatas->handover_employee_id;
                $employee = $issuedatas->employee_id;
            }
            $products = [];
            foreach ($productIds as $productId) {
                $products = Stock::whereIn('id', $productId)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
            }
            $user = User::where('employee_id', $userdetail)->first();
            $transferuser = User::where('employee_id', $handoveruserdetail)->first();
            $users = DB::table('notifications')->Where('type', 'App\Notifications\TransferNotification')->first();
            // dd($user);
            $name = User::where('employee_id', $handempl)->first();
            $namehand = User::where('employee_id', $employee)->first();
            return view('Backend.Page.Issuence.accept-transfer-controller', compact('products', 'user', 'transferdata', 'users', 'transferuser', 'description', 'transactioncode', 'createdDates', 'id', 'name', 'namehand'));
        }
    }

    public function markasreadAdmin($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return back();
    }
    public function markasreadmanager($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }

        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)
            ->orderByDesc('created_at')
            ->get();

        $productIds = [];
        $createdDates = [];
        $userdetail = [];
        foreach ($issuedata as $issuedatas) {
            $productIds[] = json_decode($issuedatas->product_id);
            $createdDates[] = $issuedatas->created_at;
            $userdetail[] = $issuedatas->employee_id;
        }
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::where('employee_id', $userdetail)->first();
        $users = DB::table('notifications')->where('type', 'App\Notifications\TransferNotification')->first();
        return view('Backend.Page.Issuence.accept', compact('products', 'createdDates', 'user', 'users'));
    }
    public function markasreadmanagertransferaccept($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return back();
    }
    public function markasreadmanagerreturn($id, $typeId)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $manager = Auth::user()->id;
        $issuedata = AssetReturn::where('id', $typeId)
            ->where('manager_user_id', $manager)
            ->orderByDesc('created_at')
            ->get();

        $productIds = [];
        $createdDates = [];
        $userdetail = [];
        $transactioncode = [];
        $description = [];
        $employee_id = '';
        foreach ($issuedata as $issuedatas) {
            $productIds[] = json_decode($issuedatas->product_id);
            $createdDates[] = $issuedatas->created_at;
            $userdetail[] = $issuedatas->employee_id;
            $transactioncode = $issuedatas->return_transaction_code;
            $description = $issuedatas->reason;
            $employee_id = $issuedatas->return_by_user;
        }
        $selectedAssetIds = collect($productIds)->flatten()->unique()->toArray();
        $products = Stock::whereIn('id', $selectedAssetIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::find($employee_id);
        $users = DB::table('notifications')->where('type', 'App\Notifications\TransferNotification')->first();
        return view('Backend.Page.Issuence.accept-return', compact('products', 'createdDates', 'user', 'users', 'description', 'transactioncode'));
    }

    public function markasreadtransfermanager($id, $typeId)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $transferdata = [];
        // dd($manager);
        $checkdata = Transfer::where('id', $typeId)->orderBy('created_at', 'desc')->get();
        if ($checkdata[0]->handover_manager_id == $checkdata[0]->employee_manager_id) {
            $transferdata = Transfer::where('id', $typeId)->where('handover_manager_id', $manager)->orderBy('created_at', 'desc')->get();
            // dd($transferdata);
        } else {
            $transferdata = Transfer::where('id', $typeId)->orderBy('created_at', 'desc')->get();
        }
        $productIds = [];
        $createdDates = [];
        $userdetail = [];
        $transactioncode = [];
        $description = [];
        $employee = [];
        $handempl = [];
        $handoveruserdetail = [];
        foreach ($transferdata as $issuedatas) {
            $productIds[] = json_decode($issuedatas->product_id);
            $createdDates[] = $issuedatas->created_at;
            $userdetail[] = $issuedatas->employee_id;
            $handoveruserdetail = $issuedatas->handover_employee_id;
            $transactioncode = $issuedatas->transfers_transaction_code;
            $description = $issuedatas->description;
            $handempl = $issuedatas->handover_employee_id;
            $employee = $issuedatas->employee_id;
        }
        $products = [];
        foreach ($productIds as $productId) {
            $products = Stock::whereIn('id', $productId)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        }
        $user = User::where('employee_id', $userdetail)->first();
        $transferuser = User::where('employee_id', $handoveruserdetail)->first();
        $users = DB::table('notifications')->Where('type', 'App\Notifications\TransferNotification')->first();
        // dd($user);
        $name = User::where('employee_id', $handempl)->first();
        $namehand = User::where('employee_id', $employee)->first();
        return view('Backend.Page.Issuence.accept-transfer', compact('products', 'user', 'transferdata', 'users', 'transferuser', 'description', 'transactioncode', 'createdDates', 'id', 'name', 'namehand'));
    }
    public function approvemanager($id)
    {
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->orderByDesc('created_at')
            ->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::where('employee_id', $issuedata->employee_id)->first();
        $issuedmanager = Status::where('name', 'Issue accept Manager')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);

        return back()->with('success', 'Aprroved.');
    }
    public function deniedmanager($id)
    {
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->orderByDesc('created_at')
            ->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::where('employee_id', $issuedata->employee_id)->first();
        $issuedmanager = Status::where('name', 'Denied by Manager')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        return back()->with('success', 'Denied.');
    }
    public function approvereturnmanager($id)
    {
        $manager = Auth::user()->id;
        $issuedmanager = Status::where('name', 'Instock')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        return back()->with('success', 'Aprroved.');
    }
    public function deniedreturnmanager($id)
    {
        $user = Auth::user()->employee_id;
        $manager = Auth::user()->id;
        $issuedata = Issuence::where('employee_id', $user)
            ->orWhere('employee_manager_id', $manager)->orderByDesc('created_at')
            ->first();
        $productIds = json_decode($issuedata->product_id);
        $products = Stock::whereIn('id', $productIds)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $user = User::where('employee_id', $issuedata->employee_id)->first();
        $issuedmanager = Status::where('name', 'Denied by Manager')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        return back()->with('success', 'Denied.');
    }
    public function approvetransfermanager($id, $nid)
    {
        $manager = Auth::user()->id;
        $updatenotification = DB::select('select * from notifications where id = ?', [$nid]);
        $transfer_id = '';
        foreach ($updatenotification as $value) {
            $transfer_id .= $value->transfer_id;
        }
        $transferdata = Transfer::where('id', $transfer_id)->where('handover_manager_id', $manager)->first();
        $user = User::where('employee_id', $transferdata->handover_employee_id)->first();
        $products = Stock::where('id', $id)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $issuedmanager = Status::where('name', 'Transferred by Manager')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        $assetcontroller = Role::where('name', 'Asset Controller')->first();
        $assettomanager = User::where('role_id', $assetcontroller->id)
            ->where('department_id', $user->department_id)->first() ?? null;
        $assettomanager->notify(new TransferNotification($assettomanager));
        $count = 0;
        $a = [];
        $lastFourRecords = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->update(['transfer_id' => $transferdata->id]);
        return back()->with('success', 'Aprroved.');
    }
    public function deniedtransfermanager($id)
    {
        $issuedmanager = Status::where('name', 'Denied by Manager')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        return back()->with('success', 'Denied.');
    }
    public function approvetransfercontroller($id, $nid)
    {
        $manager = Auth::user()->id;
        $updatenotification = DB::select('select * from notifications where id = ?', [$nid]);
        $transfer_id = '';
        foreach ($updatenotification as $value) {
            $transfer_id .= $value->transfer_id;
        }
        $transferdata = Transfer::where('id', $transfer_id)->first();
        $user = User::where('employee_id', $transferdata->handover_employee_id)->first();
        $products = Stock::where('id', $id)->with('brand', 'brandmodel', 'asset_type', 'getsupplier')->get();
        $issuedmanager = Status::where('name', 'Transferred by Controller')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        foreach ($products as $products) {
            $data = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'company_name' => 'IT-Asset',
                'transfer_from' => $transferdata->employee_id,
                'email' => $user->email,
                'product_name' => $products->product_info . ' ' . $products->assetmain->name,
                'product_serial' => $products->serial_number,
                'handover_employee' => $user->employee_id,
            ];
            $users['to'] = $user->email;
            Mail::send('Backend.Auth.mail.transfer_mail', $data, function ($message) use ($users) {
                $message->from('itasset@svamart.com', 'itasset@svamart.com');
                $message->to($users['to']);
                $message->subject('Asset Transferred Successfully.');
            });
        }
        $user->notify(new TransferNotification($user));
        $count = 0;
        $a = [];
        $lastFourRecords = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->update(['transfer_id' => $transferdata->id]);
        return back()->with('success', 'Aprroved.');
    }
    public function deniedtransfercontroller($id)
    {
        $issuedmanager = Status::where('name', 'Denied by Controller')->first();
        Stock::find($id)->update(['status_available' => $issuedmanager->id]);
        return back()->with('success', 'Denied.');
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
        $status = Status::where('name', 'Accepted by User')->orWhere('name', 'Rejected')->first();
        Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
        $user = User::where('role_id', 1)->first();
        $user->notify(new IssuenceAcceptNotification($user));
        return redirect()->back()->with('success', 'Asset Alloted!');
    }
    public function TransferAssetAccept($id)
    {
        $user = Auth::user();
        $status = Status::where('name', 'Transferred')->first();
        Stock::updateOrCreate(['id' => $id], ['status_available' => $status->id]);
        $rolemanager = Role::where('name', 'Manager')->first();
        $manager = User::where('department_id', $user->department_id)->where('role_id', $rolemanager->id)->first();
        $rolecontroller = Role::where('name', 'Asset Controller')->first();
        $controller = User::where('department_id', $user->department_id)->where('role_id', $rolecontroller->id)->first();
        $manager->notify(new TransferAcceptNotification($manager));
        $controller->notify(new TransferAcceptNotification($controller));
        return back()->with('success', 'Asset Transferred!');
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
        $issuences = Issuence::with(['assetType', 'asset', 'stock'])->get();
        $products = [];
        foreach ($issuences as $key => $value) {
            $id = json_decode($value->product_id);
            $products[] = Stock::where('id', $id)->first();
        }
        return view('Backend.Page.Issuence.all-issuence', compact('issuences', 'products'));
    }

    public function showissuence($id)
    {
        $issue = Issuence::find($id);
        $data = $issue->product_id;
        $empname = $issue->employee_id;
        $user = User::where('employee_id', $empname)->first();
        $rolid = $user->department_id;
        $assetc = User::where('department_id', $rolid)->orWhere('role_id', 6)->first();
        // dd($assetc);
        $issuances = json_decode($data);
        $stock = Stock::find($issuances);
        return view('Backend.Page.Issuence.showissuence', compact('stock', 'issue', 'user', 'assetc'));
    }

    public function issueprint($id)
    {
        $issue = Issuence::find($id);
        // dd($issue);
        $data = $issue->product_id;
        $empname = $issue->employee_id;
        $user = User::where('employee_id', $empname)->first();
        $assetcontrollerrol = Role::where('name', 'Asset Controller')->first();
        $assetc = User::where('role_id', $assetcontrollerrol->id)
            ->where('department_id', $user->department_id)->first() ?? null;
        $manager = $issue->employee_manager_id;
        $mng = User::findOrFail($manager);
        $issuances = json_decode($data);
        $stock = Stock::find($issuances);
        return view('Backend.Page.Issuence.issue-print', compact('stock', 'issue', 'user', 'assetc', 'mng'));
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
        $user = User::where('role_id', 1)->first();
        $user->notify(new IssuenceAcceptNotification($user));
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
            $user = Auth::user();
            $userdata = $user->employee_id;
            $transferdata = Transfer::where('employee_id', $userdata)->get();
            // dd($transferdata);
            return view('Backend.Page.Employee.all_transfer', compact('transferdata'));
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
                sleep(1);
                return response()->json(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to update status']);
            }
        }

        if ($product) {
            $updateResult = $product->update(['status_available' => $newStatus]);

            if ($updateResult) {
                sleep(1);
                return response()->json(['success' => true, 'message' => 'Status updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to update status']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Asset or product not found']);
    }
}
