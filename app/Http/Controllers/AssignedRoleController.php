<?php

namespace App\Http\Controllers;

use App\Models\AssignedRole;
use App\Models\AssignedService;
use Illuminate\Http\Request;

class AssignedRoleController extends Controller
{
    public function showAll(AssignedService $assignedService)
    {
        //
    }

    public function assign(Request $request , AssignedService $assignedService)
    {
        //
    }

    public function delete(AssignedRole $assignedRole)
    {
        //
    }

    public function deleteAll(AssignedService $assignedService)
    {
        //
    }

}
