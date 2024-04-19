<?php

namespace App\Http\Controllers;

use App\Models\AdvancedUser;
use App\Models\AssignedService;
use Illuminate\Http\Request;

class AssignedServiceController extends Controller
{

    public function showAssignedServices(AdvancedUser $advancedUser)
    {
        //
    }

    public function assignedService(Request $request, AdvancedUser $advancedUser)
    {
        //
    }

    public function deleteAssignedService(AssignedService $assignedService)
    {
        //
    }

    public function deleteAllAssignedServices(AdvancedUser $advancedUser)
    {
        //
    }
}
