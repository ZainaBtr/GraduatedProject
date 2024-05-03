<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedRole\AssignedRole1;
use App\Models\AssignedRole;
use App\Models\AssignedService;
use Illuminate\Http\Request;

class AssignedRoleController extends Controller
{

    public function showAll(AssignedService $assignedService)
    {
        //
    }

    public function assign(AssignedRole1 $request, AssignedService $assignedService)
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
