<?php

namespace App\Traits;

use App\Permission;


trait HasPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

    public function givePermission($permissions)
    {  
        if($permissions === null)
        {
            $this->permissions()->detach();

            return $this;
        }

        $permissions = $this->getAllPermissions($permissions);

        $this->permissions()->detach();

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name',$permission->name)->count();
    }

    protected function getAllPermissions(array $permissions = [])
    {
        return Permission::whereIn('id',$permissions)->get();
    }
}