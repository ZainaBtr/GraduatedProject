<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedService\AssignedService1;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use Illuminate\Http\Response;

class AssignedServiceController extends Controller
{

    public function showAll(AdvancedUser $advancedUser)
    {
        $allRecords = AssignedService::where('advancedUserID', $advancedUser['id'])->with('service')->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function assign(AssignedService1 $request, AdvancedUser $advancedUser)
    {
        $data = $request->validated();

        $data['advancedUserID'] = $advancedUser['id'];

        $recordStored = AssignedService::create($data);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function delete(AssignedService $assignedService)
    {
        $assignedService->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll(AdvancedUser $advancedUser)
    {
        AssignedService::where('advancedUserID', $advancedUser['id'])->delete();

        return response()->json(['message' => 'all records deleted successfully']);
    }

}
