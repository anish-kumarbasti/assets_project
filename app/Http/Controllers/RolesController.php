<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
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
    public function fetchrole($id){
        $permissions = DB::table('role_has_permissions')
        ->select('permissions.name')
        ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
        ->where('role_has_permissions.role_id', $id)
        ->get();
        // dd($permissions);
        return response()->json(['permissions' => $permissions]);   
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
        $permissions=$request->permissions;
        $user=Auth::user();
        // dd($permissions->id);
        foreach($permissions as $permission){
            DB::table('model_has_permissions')->insert([
                'permission_id' => $permission,
                'model_type' => get_class($user), // Assuming User model
                'model_id' => $user->id,
            ]);
            $roles=$role->givePermissionTo($permission);
        }

      
        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
    }
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
