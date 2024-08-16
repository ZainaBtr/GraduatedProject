<?php

namespace App\Services;

use App\Http\Requests\AssignedRole\AssignedRole1;
use App\Models\AssignedRole;
use App\Models\AssignedService;
use App\Models\Role;
use App\Models\ServiceManager;

class AssignedRoleService
{
    public function showRoleForDynamicDropDown()
    {
        return Role::all()->unique()->values();
    }

    public function showAll(AssignedService $assignedService)
    {
        return AssignedRole::where('assignedServiceID', $assignedService['id'])->with('role')->get();
    }

    public function assign(AssignedRole1 $request, AssignedService $assignedService)
    {
        $data = $request->validated();

        $allData['roleID'] = $data['id'];

        $allData['assignedServiceID'] = $assignedService['id'];

        return AssignedRole::create($allData);
    }

    public function delete(AssignedRole $assignedRole)
    {
        $assignedRole->delete();

        return ['message' => 'this record deleted successfully'];
    }

    public function deleteAll(AssignedService $assignedService)
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            AssignedRole::where('assignedServiceID', $assignedService['id'])->delete();

            return ['message' => 'all records deleted successfully'];
        }
        return ['message' => 'you dont have the permission to delete all records in this table'];
    }
}
