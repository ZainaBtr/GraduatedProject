<?php

namespace App\Services;

use App\Models\Role;
use App\Models\ServiceManager;

class RoleService
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function createRole($validatedData)
    {
        return Role::create($validatedData);
    }

    public function deleteRole(Role $role)
    {
        $role->delete();

        return ['message' => 'This record deleted successfully'];
    }

    public function deleteAllRoles()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            Role::query()->delete();

            return ['message' => 'All records deleted successfully'];
        }
        return ['message' => 'You don’t have permission to delete all records in this table'];
    }
}
