<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedService\AssignedService1;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use App\Models\ServiceManager;
use Illuminate\Http\Response;

class AssignedServiceController extends Controller
{

    public function showAll(AdvancedUser $advancedUser)
    {
        $allRecords = AssignedService::where('advancedUserID', $advancedUser->id)->with('service')->get();
        return view('pages.AdvancedUserServicePageForServiceManager', [
            'allRecords' => $allRecords,
            'advancedUser' => $advancedUser
        ]);
        
    }

    public function assign(AssignedService1 $request, AdvancedUser $advancedUser)
    {
        $data = $request->validated();

        $allData['serviceID'] = $data['id'];

        $allData['advancedUserID'] = $advancedUser['id'];

        $recordStored = AssignedService::create($allData);
        return redirect()->back();

        return response()->json($recordStored, Response::HTTP_OK);
    }
    public function delete(AssignedService $assignedService)
    {
        $assignedService->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll(AdvancedUser $advancedUser)
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            AssignedService::where('advancedUserID', $advancedUser['id'])->delete();
            return redirect()->back();

            return response()->json(['message' => 'all records deleted successfully']);
        }
        return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
    }

}
