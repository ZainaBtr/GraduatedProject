<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedRole\AssignedRole1;
use App\Models\AssignedRole;
use App\Models\AssignedService;
use App\Models\ServiceManager;
use Illuminate\Http\Response;

class AssignedRoleController extends Controller
{

    public function showAll(AssignedService $assignedService)
    {
        $allRecords = AssignedRole::where('assignedServiceID', $assignedService['id'])->with('role')->get();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('');
    }

    public function assign(AssignedRole1 $request, AssignedService $assignedService)
    {
        $data = $request->validated();

        $allData['roleID'] = $data['id'];

        $allData['assignedServiceID'] = $assignedService['id'];

        $recordStored = AssignedRole::create($allData);

        if (request()->is('api/*')) {
            return response()->json($recordStored, Response::HTTP_OK);
        }
        return view('');
    }

    public function delete(AssignedRole $assignedRole)
    {
        $assignedRole->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'this record deleted successfully']);
        }
        return view('');
    }

    public function deleteAll(AssignedService $assignedService)
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            AssignedRole::where('assignedServiceID', $assignedService['id'])->delete();

            if (request()->is('api/*')) {
                return response()->json(['message' => 'all records deleted successfully']);
            }
            return view('');
        }
        if (request()->is('api/*')) {
            return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
        }
        return view('');
    }

}
