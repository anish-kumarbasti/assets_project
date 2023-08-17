<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
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
        $users = User::with(['department', 'designation'])->get();

        return view('Backend.Page.User.all_users', compact('users'));
    }
    public function showUsers()
    {
        $users = User::with(['department', 'designation'])->get();
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
        return view('Backend.Page.User.add-user', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'password' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',

        ]);

        $profile_photo = null;
        $cover_photo = null;

        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo')->storePublicly('profile_photos', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            $cover_photo = $request->file('cover_photo')->storePublicly('cover_photos', 'public');
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'age' => $request->age,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'profile_photo' => $profile_photo,
            'cover_photo' => $cover_photo,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'mobile_number' => $request->mobile_number,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function getDesignations($departmentId)
    {
        $designations = Designation::where('department_id', $departmentId)->pluck('designation', 'id');

        return response()->json($designations);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $department = Department::all();
        $designation = Designation::all();
        return view('Backend.Page.User.edit', compact('user', 'department', 'designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image',
            'cover_photo' => 'nullable|image',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'mobile_number' => 'required|numeric',
        ]);
        //$user = User::where('id', $id)->first();
        $user = User::findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->profile_photo = $request->input('profile_photo');
        $user->department_id = $request->input('department_id');
        $user->designation_id = $request->input('designation_id');
        $user->mobile_number = $request->input('mobile_number');
        dd($user);
        $user->update();
        if ($request->hasFile('profile_photo')) {
            $request['profile_photo'] = $request->file('profile_photo')->store('profile_photos');
        }

        if ($request->hasFile('cover_photo')) {
            $request['cover_photo_path'] = $request->file('cover_photo')->store('cover_photos');
        }
        // User::where('id', $id)->update($data);
        // $user->update($data)->where('id', $id);
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
    public function users_profile()
    {
        return view('Backend.Page.User.user-profile');
    }
}
