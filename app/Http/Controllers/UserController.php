<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User;

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
    public function user(){
        return view('Backend.Page.User.add-user');

    }

    public function userCard(){
        return view('Backend.Page.User.user-details');
    }
        public function userProfile(){
            return view('Backend.Page.User.user-profile');




    }

}
