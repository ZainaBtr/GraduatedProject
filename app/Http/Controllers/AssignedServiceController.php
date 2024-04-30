<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedService\AssignedService1;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use Illuminate\Http\Request;

class AssignedServiceController extends Controller
{

    public function showAll(AdvancedUser $advancedUser)
    {
        //
    }

    public function assign(AssignedService1 $request, AdvancedUser $advancedUser)
    {
        //
    }

    public function delete(AssignedService $assignedService)
    {
        //
    }

    public function deleteAll(AdvancedUser $advancedUser)
    {
        //
    }

}
