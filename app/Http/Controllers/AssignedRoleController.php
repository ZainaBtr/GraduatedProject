<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedRole\AssignedRole1;
use App\Models\AssignedRole;
use App\Models\AssignedService;
use App\Models\ServiceManager;
use Illuminate\Http\Response;
use App\Models\Role;

class AssignedRoleController extends Controller
{

    
    public function showRoleForDynamicDropDown()
    {
        $allRecords = Role::all()
            ->unique()
            ->values();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAll(AssignedService $assignedService)
    {
        $allRecords = AssignedRole::where('assignedServiceID', $assignedService['id'])->with('role')->get();

        return view('pages.AdvancedUserRolePageForServiceManager', [
            'allRecords' => $allRecords,
            'assignedService' => $assignedService
        ]);
    }

    public function assign(AssignedRole1 $request, AssignedService $assignedService)
    {
        $data = $request->validated();

        $allData['roleID'] = $data['id'];

        $allData['assignedServiceID'] = $assignedService['id'];

        $recordStored = AssignedRole::create($allData);
        return redirect()->back();

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function delete(AssignedRole $assignedRole)
    {
        $assignedRole->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll(AssignedService $assignedService)
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            AssignedRole::where('assignedServiceID', $assignedService['id'])->delete();
            return redirect()->back();

            return response()->json(['message' => 'all records deleted successfully']);
        }
        return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
    }

}
