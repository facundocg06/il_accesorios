<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::with('roles', 'permissions')->get();
        return view('admin.role-permission.index', compact('roles', 'permissions', 'users'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create(['name' => $request->name]);
        return back()->with('success', 'Rol creado con éxito');
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permiso creado con éxito');
    }

    public function assignRole(Request $request)
    {
        $user = User::find($request->user_id);
        $user->syncRoles($request->roles);
        return back()->with('success', 'Rol asignado con éxito');
    }

    public function assignPermission(Request $request)
    {
        $user = User::find($request->user_id);
        $user->syncPermissions($request->permissions);
        return back()->with('success', 'Permiso asignado con éxito');
    }
    public function removeRole(Request $request)
    {
        $user = User::find($request->user_id);
        $user->removeRole($request->role);
        return back()->with('success', 'Rol eliminado con éxito');
    }

    public function removePermission(Request $request)
    {
        $user = User::find($request->user_id);
        $user->revokePermissionTo($request->permission);
        return back()->with('success', 'Permiso eliminado con éxito');
    }
}
