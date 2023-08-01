<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $permissions = Permission::all();
        return view('Backend.Page.roles.permissions', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
    }
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
