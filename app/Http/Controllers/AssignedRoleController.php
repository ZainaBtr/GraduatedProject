<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedRole\AssignedRole1;
use App\Models\AssignedRole;
use App\Models\AssignedService;
use App\Services\AssignedRoleService;
use Illuminate\Http\Response;

class AssignedRoleController extends Controller
{
    protected $assignedRoleService;

    public function __construct(AssignedRoleService $assignedRoleService)
    {
        $this->assignedRoleService = $assignedRoleService;
    }

    public function showRoleForDynamicDropDown()
    {
        $allRecords = $this->assignedRoleService->showRoleForDynamicDropDown();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('',compact('allRecords'));
    }

    public function showAll(AssignedService $assignedService)
    {
        $allRecords = $this->assignedRoleService->showAll($assignedService);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.AdvancedUserRolePageForServiceManager', [
            'allRecords' => $allRecords,
            'assignedService' => $assignedService
        ]);
    }

    public function assign(AssignedRole1 $request, AssignedService $assignedService)
    {
        $recordStored = $this->assignedRoleService->assign($request, $assignedService);

        if (request()->is('api/*')) {

            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function delete(AssignedRole $assignedRole)
    {
        $response = $this->assignedRoleService->delete($assignedRole);

        if (request()->is('api/*')) {

            return response()->json($response, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function deleteAll(AssignedService $assignedService)
    {
        $response = $this->assignedRoleService->deleteAll($assignedService);

        if (request()->is('api/*')) {

            return response()->json($response, Response::HTTP_OK);
        }
        return redirect()->back();
    }
}
