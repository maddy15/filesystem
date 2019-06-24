<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permission;
use App\Role;

class UserPermissionController extends Controller
{
    public function index(User $user)
    {
        $permissions = Permission::all();
        $roles = Role::all();

        return view('admin.user.permission.index',[
            'user' => $user,
            'permissions' => $permissions,
            'roles' => $roles,
            'users_role' => $user->roles->pluck('id')->toArray(),
            'users_permission' => $user->permissions->pluck('id')->toArray()
        ]);
    }

    public function store(Request $request,User $user)
    {
        return $request->all();
         $user->givePermission($request->permission);
         return back()->withSuccess('Permission added to ' . $user->name);
    }
}
