<?php

namespace App\Http\Controllers;

use App\Models\InterestedService;
use App\Models\Service;
use Illuminate\Http\Response;

class InterestedServiceController extends Controller
{

    public function showAll()
    {
        $allRecords = InterestedService::whereHas('service', function ($query) {
            $query->whereNull('parentServiceID')
                ->where('status', 1);
        })
            ->where('userID', auth()->id())
            ->with('service')
            ->get();

        foreach ($allRecords as $record) {
            $record->service['children'] = Service::where('parentServiceID', $record->service['id'])
                ->where('status', 1)
                ->get();
        }

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAllParent()
    {
        $allRecords = Service::with(['interestedService', 'serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.advancedUser.user', 'assignedService.assignedRole.role'])
            ->whereHas('interestedService', function ($query) {
                $query->where('userID', auth()->id());
            })
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showChild(Service $service)
    {
        $allRecords = Service::with(['interestedService', 'serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.advancedUser.user', 'assignedService.assignedRole.role'])
            ->where('parentServiceID', $service['id'])
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function interestIn(Service $service)
    {
        $data['userID'] = auth()->id();
        $data['serviceID'] = $service['id'];

        $recordStored = InterestedService::create($data);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function unInterestIn(InterestedService $interestedService)
    {
        $interestedService->delete();

        return response()->json(['message' => 'this service uninterested successfully']);
    }

}
