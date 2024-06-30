<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedService\AssignedService1;
use App\Models\User;
use App\Models\AssignedService;
use App\Models\ServiceManager;
use Illuminate\Http\Response;

class AssignedServiceController extends Controller
{

    public function showAll(User $user)
    {
        $allRecords = AssignedService::where('userID', $user['id'])->with('service')->get();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.AdvancedUserServicePageForServiceManager', [
            'allRecords' => $allRecords,
            'user' => $user
        ]);
    }

    public function assign(AssignedService1 $request, User $user)
    {
        $data = $request->validated();

        $allData['serviceID'] = $data['id'];

        $allData['userID'] = $user['id'];

        $recordStored = AssignedService::create($allData);
        return redirect()->back();

        if (request()->is('api/*')) {
            return response()->json($recordStored, Response::HTTP_OK);
        }
        return view('');
    }
    public function delete(AssignedService $assignedService)
    {
        $assignedService->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'this record deleted successfully']);
        }
        return view('');
    }

    public function deleteAll(User $user)
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            AssignedService::where('userID', $user['id'])->delete();
            return redirect()->back();

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
