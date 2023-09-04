<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $modules = [
            'Permissions',
            'Role',
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
        $permission = Permission::all();
        return view('Backend.Page.roles.all-permissions', compact('modules', 'permission', 'roles'));
    }
    public function store(Request $request){
        $permission = Permission::create(['name' => $request->input('name')]);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }
    public function update(Request $request)
    {
        // Loop through the submitted data and update permissions

        foreach ($request->all() as $module => $permissions) {
            foreach ($permissions as $permissionName => $isChecked) {
                Permission::updateOrCreate(['name' => $module . '.' . $permissionName], ['guard_name' => 'web']);
            }
        }

        return redirect()->route('admin.permissions.index')->with('success', 'Permissions updated successfully.');
    }
}
