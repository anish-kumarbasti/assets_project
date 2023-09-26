<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('Backend.Page.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    public function fetchrole($id)
    {
        $permissions = DB::table('role_has_permissions')
            ->select('permission_id') // Change 'permissions.name' to 'permission_id'
            ->where('role_id', $id)
            ->get();

        // Extract the permission IDs from the fetched data
        $permissionIds = $permissions->pluck('permission_id')->toArray();

        // Debug: Log the extracted permission IDs
        // dd($permissionIds);
        return response()->json(['permissions' => $permissionIds]);
    }

    public function edit(Role $role)
    {
        return view('Backend.Page.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->input('name')]);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function permissions(Role $role)
    {
        // dd($role);
        $permissions = Permission::all();
        return view('Backend.Page.roles.permissions', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role)
    {

        $permissions = $request->permissions;
        $user = Auth::user();
        // dd($request);
        foreach ($permissions as $permission) {
            DB::table('model_has_permissions')->insert([
                'permission_id' => $permission,
                'model_type' => get_class($user), // Assuming User model
                'model_id' => $user->id,
            ]);
            $roles = $role->givePermissionTo($permission);
        }

        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
    }

    public function updateAdminPermissions(Request $request, Role $role)
    {
        $permissionsToAdd = $request->permissions;
        $user = Auth::user();
        
        $usersWithRole = User::where('role_id', $role->id)->get();
     
        if ($usersWithRole->isNotEmpty()) {
            foreach ($usersWithRole as $userWithRole) {
                $existingUserPermissions = DB::table('model_has_permissions')
                    ->where('model_type', get_class($userWithRole))
                    ->where('model_id', $userWithRole->id)
                    ->pluck('permission_id')
                    ->toArray();
                $existingRolePermissions = $role->permissions->pluck('id')->toArray();
                $permissionsToAddForUser = array_diff($permissionsToAdd, $existingUserPermissions, $existingRolePermissions);
                if (!empty($permissionsToAddForUser)) {
                    foreach ($permissionsToAddForUser as $permission) {
                        DB::table('model_has_permissions')->insert([
                            'permission_id' => $permission,
                            'model_type' => get_class($userWithRole),
                            'model_id' => $userWithRole->id,
                        ]);
                        $role->givePermissionTo($permission);
                    }
                }
            }
            return back()->with('success', 'Permissions updated successfully.');
        } else {
            return back()->with('danger', 'No users found for the selected role.');
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
        }
        return response()->json(['success' => true]);
    }
}
