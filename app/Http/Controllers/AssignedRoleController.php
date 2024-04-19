<?php

namespace App\Http\Controllers;

use App\Models\AssignedRole;
use App\Models\AssignedService;
use Illuminate\Http\Request;

class AssignedRoleController extends Controller
{

    public function assignedRole(Request $request , AssignedService $assignedService)
    {
        //
    }

    public function showAssignedRoles(AssignedService $assignedService)
    {
        //
    }

    public function deleteAssignedRole(AssignedRole $assignedRole)
    {
        //
    }

    public function deleteAllAssignedRoles(AssignedService $assignedService)
    {
        //
    }

}
