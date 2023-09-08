<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::all();
        return view('Backend.Page.roles.all-permissions', compact('permission'));
    }
    public function destroy($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
        }
        return response()->json(['success' => true]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
        ]);
        $permission = Permission::create(['name' => $request->input('name')]);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }
    public function update(Request $request, Permission $permission, $id)
    {
        // dd($id);
        $permission->find($id)->update(['name' => $request->input('name')]);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
        // Loop through the submitted data and update permissions
        // foreach ($request->all() as $module => $permissions) {
        //     foreach ($permissions as $permissionName => $isChecked) {
        //         Permission::updateOrCreate(['name' => $module . '.' . $permissionName], ['guard_name' => 'web']);
        //     }
        // }

        return redirect()->route('admin.permissions.index')->with('success', 'Permissions updated successfully.');
    }
    public function edit(Permission $permission)
    {
        return view('Backend.Page.Role-Permission.edit_permission', compact('permission'));
    }
    public function permission()
    {
        $modules = [
            'Permissions',
            'Role',
            'Master',
            'Stock',
            'Assets',
            'User',
            'Issuance',
            'Department',
            'Designation',
            'Setting',
        ];
        $permissions = Permission::pluck('name')->toArray();
        $roles = Role::pluck('name')->toArray();
        $chooserole = Role::all();
        // dd($roles);
        return view('Backend.Page.Role-Permission.permission', compact('modules', 'roles', 'permissions', 'chooserole'));
    }
}
