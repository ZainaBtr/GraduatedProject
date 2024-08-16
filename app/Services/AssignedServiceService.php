<?php

namespace App\Services;

use App\Http\Requests\AssignedService\AssignedService1;
use App\Models\AssignedService;
use App\Models\ServiceManager;
use App\Models\User;

class AssignedServiceService
{
    public function showAll(User $user)
    {
        return AssignedService::where('userID', $user['id'])->with('service')->get();
    }

    public function assign(AssignedService1 $request, User $user)
    {
        $data = $request->validated();

        $allData['serviceID'] = $data['id'];

        $allData['userID'] = $user['id'];

        return AssignedService::create($allData);
    }

    public function delete(AssignedService $assignedService)
    {
        $assignedService->delete();

        return ['message' => 'this record deleted successfully'];
    }

    public function deleteAll(User $user)
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            AssignedService::where('userID', $user['id'])->delete();

            return ['message' => 'all records deleted successfully'];
        }
        return ['message' => 'you dont have the permission to delete all records in this table'];
    }
}
