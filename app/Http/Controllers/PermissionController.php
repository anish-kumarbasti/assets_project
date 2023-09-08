<?php

namespace App\Http\Controllers;

use App\Models\PermissionManage;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::all();
        return view('Backend.Page.roles.all-permissions', compact( 'permission'));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:20',
        ]);
         Permission::create(['name' => $request->input('name')]);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }
    public function update(Request $request,Permission $permission,$id)
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
    public function permission(){
        $permissions = Permission::pluck('name')->toArray();
        $roles = Role::pluck('name')->toArray();
        $chooserole = Role::all();
        $permissionmanages = Permission::all();
        $permissionsByModule = $permissionmanages->groupBy('module');
        $permissionTypes = ['manage', 'create', 'edit', 'delete'];
        //  dd($permissionsByModule);
        return view('Backend.Page.Role-Permission.permission', compact('roles','permissions','chooserole','permissionmanages','permissionsByModule','permissionTypes'));
    }
}
