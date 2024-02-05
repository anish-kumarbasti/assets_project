<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Models\AssetReturn;
use App\Models\BusinessSetting;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Issuence;
use App\Models\Location;
use App\Models\Stock;
use App\Models\SubLocationModel;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function trash()
    {
        $users = User::onlyTrashed(['department', 'designation'])->get();
        return view('Backend.Page.User.trash', compact('users'));
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!empty($user)) {
            $user->restore();
        }
        return redirect()->route('users.index')->with('success', 'User Restore Successfully');
    }
    public function assignRoles(User $user)
    {
        $roles = Role::all();
        return view('users.assign_roles', compact('user', 'roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $user->syncRoles($request->input('roles'));
        return redirect()->route('users.index')->with('success', 'Roles assigned successfully.');
    }
    public function user()
    {
        return view('Backend.Page.User.add-user');
    }

    public function userCard()
    {
        return view('Backend.Page.User.user-details');
    }
    public function userProfile()
    {

        return view('Backend.Page.User.user-profile');
    }
    public function index()
    {
        $users = User::with(['department', 'designation'])->orderBy('created_at', 'DESC')->get();

        return view('Backend.Page.User.all_users', compact('users'));
    }
    public function showUsers()
    {
        $users = User::with(['department', 'designation'])->orderBy('created_at', 'DESC')->get();
        // dd($users);
        return view('Backend.Page.User.user-details', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $role = Role::all();
        $location = Location::all();
        return view('Backend.Page.User.add-user', compact('departments', 'role', 'location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        if ($image = $request->file('profile_photo')) {
            $destinationPath = 'images';
            $imagess = date('YmdHis') . random_int(1, 10000) . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imagess);
            $pathprofile = $destinationPath . '/' . $imagess;
        }
        if ($image = $request->file('cover_photo')) {
            $destinationPath = 'images';
            $imagess = date('YmdHis') . random_int(1, 10000) . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imagess);
            $pathcover = $destinationPath . '/' . $imagess;
        }
        // dd($request);
        $request->validate([
            'first_name' => 'required|string|max:15',
            'last_name' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|numeric',
            'gender' => 'required',
            'role' => 'required|integer',
            'password' => 'required|string',
            'department_id' => 'required|integer',
            'designation_id' => 'required|integer',
            'location_id' => 'required|integer',
            'sub_location_id' => 'required|integer',
            'mobile_number' => 'required|numeric|digits_between:10,12',
            'employee_id' => ['required', 'unique:users,employee_id', 'regex:/^[a-zA-Z0-9]+$/'],
        ]);
        $user = User::create([
            'employee_id' => $request->employee_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo' => $pathprofile ?? 'dfsrdg',
            'cover_photo' => $pathcover ?? 'dfsrdg',
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'mobile_number' => $request->mobile_number,
            'role_id' => $request->role,
            'gender' => $request->gender,
            'age' => $request->age,
            'location_id' => $request->location_id,
            'sub_location_id' => $request->sub_location_id,

        ]);
        $department = Department::where('id', $request->department_id)->first();
        $designation = Designation::where('id', $request->designation_id)->first();
        $location = Location::where('id', $request->location_id)->first();
        $logo = BusinessSetting::where('title', 'logo_path')->first();
        $data = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'company_name' => 'IT-Asset',
            'employee_id' => $request->employee_id,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $department->name,
            'designation' => $designation->designation,
            'location' => $location->name,
            'logo' => $logo->value ?? '',
        ];
        $users['to'] = $request->email;
        Mail::send('Backend.Auth.mail.message', $data, function ($message) use ($users) {
            $message->from('itasset@svamart.com', 'itasset@svamart.com'); // Replace with your email and name
            $message->to($users['to']);
            $message->subject('Registered Succesfully.');
        });
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function getDesignations($departmentId)
    {
        $designations = Designation::where('department_id', $departmentId)->pluck('designation', 'id');

        return response()->json($designations);
    }

    public function getlocations($locationId)
    {
        $sublocation = SubLocationModel::where('location_id', $locationId)->pluck('name', 'id');
        return response()->json($sublocation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::all();
        $designation = Designation::all();
        $role = Role::all();
        $user = User::find($id);
        return view('Backend.Page.User.edit', compact('user', 'department', 'designation', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // dd($request,$id);
        $request->validate([
            'first_name' => 'required|max:15|min:2',
            'last_name' => 'required|max:15|min:2',
            // 'email' => 'required|email|unique:users,email,' . $id,
            'department_id' => 'required|integer',
            'designation_id' => 'required|integer',
            'age' => 'required',
            'mobile_number' => 'required|integer|digits_between:10,12',
            'role' => 'required|integer',

        ]);
        //$user = User::where('id', $id)->first();
        $user = User::findOrFail($id);
        // dd($user,$request);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->age = $request->input('age');
        $user->department_id = $request->input('department_id');
        $user->designation_id = $request->input('designation_id');
        $user->mobile_number = $request->input('mobile_number');
        $user->role_id = $request->input('role');

        if ($image = $request->file('profile_photo')) {
            $destinationPath = 'images';
            $imagess = date('YmdHis') . random_int(1, 10000) . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imagess);
            $pathprofile = $destinationPath . '/' . $imagess;
        }

        if ($image = $request->file('cover_photo')) {
            $destinationPath = 'images';
            $imagess = date('YmdHis') . random_int(1, 10000) . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imagess);
            $pathcover = $destinationPath . '/' . $imagess;
        }
        $user->profile_photo = $pathprofile;
        $user->cover_photo = $pathcover;
        $user->update();
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function users_profile($id)
    {
        $user = User::find($id);
        $issueproduct = Issuence::where('employee_id', $user->employee_id)->count();
        $itasset = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 1)->count();
        $nonitasset = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 2)->count();
        $component = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 4)->count();
        $software = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 3)->count();
        $transfer = Transfer::where('employee_id', $user->employee_id)->count();
        $returns = AssetReturn::where('return_by_user', $user->id)->count();
        $returnproducts = json_decode(AssetReturn::where('return_by_user', $user->id)->pluck('product_id'));
        $ittransfer = 0;
        $nonittransfer = 0;
        $componenttransfer = 0;
        $softwaretransfer = 0;
        $transferProducts = Transfer::where('employee_id', $user->employee_id)->pluck('product_id');
        $ittransfer = 0;
        $nonittransfer = 0;
        $componenttransfer = 0;   
        $softwaretransfer = 0;

        if ($transferProducts) {
            foreach ($transferProducts as $product) {
                $decodedProducts = json_decode($product);
                foreach ($decodedProducts as $decodedProducts) {
                    $transferProduct = Stock::find($decodedProducts);
                    if ($transferProduct) {
                        if ($transferProduct->asset_type_id == 1) {
                            $ittransfer = $ittransfer + 1;
                        }
                        if ($transferProduct->asset_type_id == 2) {
                            $nonittransfer = $nonittransfer + 1;
                        }
                        if ($transferProduct->asset_type_id == 4) {
                            $componenttransfer = $componenttransfer + 1;
                        }
                        if ($transferProduct->asset_type_id == 3) {
                            $softwaretransfer = $softwaretransfer + 1;
                        }
                    }
                }
            }

        }

        $itreturns = 0;
        $nonitreturns = 0;
        $softwarereturns = 0;
        $compnentreturns = 0;

        if ($returnproducts) {
            foreach ($returnproducts as $returnproducts) {
                $productID = json_decode($returnproducts);
                foreach ($productID as $return) {
                    $returnProducts = Stock::find($return);
                    if ($returnProducts->asset_type_id == 1) {
                        $itreturns = $itreturns + 1;
                    }
                    if ($returnProducts->asset_type_id == 2) {
                        $nonitreturns = $nonitreturns + 1;
                    }
                    if ($returnProducts->asset_type_id == 4) {
                        $compnentreturns = $compnentreturns + 1;
                    }
                    if ($returnProducts->asset_type_id == 3) {
                        $softwarereturns = $softwarereturns + 1;
                    }
                }
            }
        }

        $totalitasset = ($itasset - $itreturns) - $ittransfer;
        $totalnonitasset = ($nonitasset - $nonitreturns) - $nonittransfer;
        $totalcomponent = ($component - $compnentreturns) - $componenttransfer;
        $totalsoftware = ($software - $softwarereturns) - $softwaretransfer;

        return view('Backend.Page.User.user-profile', compact('user', 'issueproduct', 'transfer', 'returns', 'totalitasset', 'totalnonitasset', 'totalcomponent', 'totalsoftware'));
    }
    public function usersprofile()
    {
        return view('Backend.Page.User.user-profile');
    }
    public function export()
    {
        return Excel::download(new UserExport(), 'User_format.xlsx');
    }
    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new UserImport(), $path)->first()->skip(1);
        foreach ($data as $row) {
            $names = explode(' ', $row[1], 2);
            $department = Department::updateOrCreate(
                ['unique_id' => $row[7]],
                [
                    'name' => $row[8],
                    'unique_id' => $row[7],
                ]
            );
            $designation = Designation::updateOrCreate(
                ['designation' => $row[9]],
                [
                    'designation' => $row[9],
                    'department_id' => $department->id,
                ]
            );
            $location = Location::updateOrCreate(
                ['name' => $row[10]],
                [
                    'name' => $row[10],
                ]
            );
            $sublocation = SubLocationModel::updateOrCreate(
                ['name' => $row[11]],
                [
                    'name' => $row[11],
                    'location_id' => $location->id,
                ]
            );
            $role = Role::updateOrCreate(
                ['name' => $row[12]],
                ['name' => $row[12]]
            );
            User::updateOrCreate(
                ['employee_id' => $row[0]],
                [
                    'employee_id' => $row[0],
                    'first_name' => $names[0],
                    'last_name' => $names[1],
                    'email' => $row[2],
                    'mobile_number' => $row[3],
                    'age' => $row[4],
                    'gender' => $row[5],
                    'password' => Hash::make($row[6]),
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'location_id' => $location->id,
                    'sub_location_id' => $sublocation->id,
                    'role_id' => $role->id,
                ]
            );
        }
        return redirect()->route('users.index')->with('message', 'Data imported successfully.');
    }
}
