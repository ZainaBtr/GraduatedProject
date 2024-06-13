<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\Service1;
use App\Http\Requests\Service\Service2;
use App\Http\Requests\Service\Service3;
use App\Http\Requests\Service\Service4;
use App\Models\AssignedService;
use App\Models\Service;
use App\Models\ServiceManager;
use App\Models\ServiceYearAndSpecialization;
use Illuminate\Http\Response;

class ServiceController extends Controller
{

    public function showAllParent()
    {
        $allRecords = Service::with(['serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.advancedUser.user', 'assignedService.assignedRole.role'])
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showChild(Service $service)
    {
        $allRecords = Service::with(['serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.advancedUser.user', 'assignedService.assignedRole.role'])
            ->where('parentServiceID', $service['id'])
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showByYearAndSpecialization(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        $allRecords = Service::where('serviceYearAndSpecializationID', $serviceYearAndSpecialization['id'])
            ->whereNull('parentServiceID')
            ->where('status', 1)
            ->get();

        foreach ($allRecords as $record) {
            $record['children'] = Service::where('parentServiceID', $record['id'])
                ->where('status', 1)
                ->get();
        }

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showByType($type)
    {
        $allRecords = Service::where('serviceType', $type)
            ->whereNull('parentServiceID')
            ->where('status', 1)
            ->get();

        foreach ($allRecords as $record) {
            $record['children'] = Service::where('parentServiceID', $record['id'])
                ->where('status', 1)
                ->get();
        }

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showMyAllParentFromServiceManager()
    {
        $allRecords = Service::join('services_managers', 'services.serviceManagerID', '=', 'services_managers.id')
            ->where('services_managers.userID', auth()->id())
            ->whereNull('services.parentServiceID')
            ->orderByDesc('services.status')
            ->select('services.*')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showMyChildFromServiceManager(Service $service)
    {
        $allRecords = Service::join('services_managers', 'services.serviceManagerID', '=', 'services_managers.id')
            ->where('services_managers.userID', auth()->id())
            ->where('services.parentServiceID', $service['id'])
            ->orderByDesc('services.status')
            ->select('services.*')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showMyFromAdvancedUser()
    {
        $allData = AssignedService::join('services', 'assigned_services.serviceID', '=', 'services.id')
            ->join('advanced_users', 'assigned_services.advancedUserID', '=', 'advanced_users.id')
            ->where('advanced_users.userID', auth()->id())
            ->where('services.status', 1)
            ->select('services.*')
            ->get();

        $allRecords = [];

        foreach ($allData as $data) {
            $record = [];
            if($data['parentServiceID'] == null && !isset($allRecords[$data['id']])) {
                $record['parent'] = $data;
                $record['children'] = Service::where('parentServiceID', $data['id'])
                    ->where('status', 1)
                    ->get();
                $allRecords[$data['id']] = $record;
            }
            else if ($data['parentServiceID'] != null && !isset($allRecords[$data['parentServiceID']])) {
                $record['parent'] = Service::where('id', $data['parentServiceID'])
                    ->where('status', 1)
                    ->first();
                $record['children'] = Service::where('parentServiceID', $data['parentServiceID'])
                    ->where('status', 1)
                    ->get();
                $allRecords[$data['parentServiceID']] = $record;
            }
        }

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAdvancedUsersOfService(Service $service)
    {
        $allRecords = $service->assignedService->map(function ($assignedService) {
            return [
                'advancedUserID' => $assignedService->advancedUserID,
                'fullName' => $assignedService->advancedUser->user->fullName,
                'roles' => $assignedService->assignedRole->pluck('role.roleName')
            ];
        });

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function add(Service1 $request, ?Service $parentService = null)
    {
        $data = $request->validated();

        $data['serviceManagerID'] = ServiceManager::where('userID', auth()->id())->value('id');

        if ($parentService && $parentService->exists) {
            $data['parentServiceID'] = $parentService['id'];
        }

        $recordStored = Service::create($data);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function update(Service2 $request, Service $service)
    {
        $service->update($request->validated());

        return response()->json($service, Response::HTTP_OK);
    }

    public function delete(Service $service)
    {
        $service->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll()
    {
        Service::query()->delete();

        return response()->json(['message' => 'all records deleted successfully']);
    }

    public function searchForServiceManager(Service3 $request)
    {
        $searchResults = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        return response()->json($searchResults, Response::HTTP_OK);
    }

    public function searchForAdvancedUser(Service3 $request)
    {
        $searchResults = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')
            ->whereNull('parentServiceID')
            ->where('status', 1)
            ->get();

        return response()->json($searchResults, Response::HTTP_OK);
    }

    public function filterByType(Service4 $request)
    {
        $filterType = $request['filterType'];
        $filterName = $request['filterName'];

        $query = Service::whereNull('parentServiceID')
            ->orderByDesc('status');

        if ($filterType == 'serviceYear' || $filterType == 'serviceSpecializationName') {
            $query->whereHas('serviceYearAndSpecialization', function ($subQuery) use ($filterType, $filterName) {
                $subQuery->where($filterType, $filterName);
            });
        }

        elseif ($filterType == 'serviceType' || $filterType == 'status') {
            $query->where($filterType, $filterName);
        }

        $filteredServices = $query->get();

        return response()->json($filteredServices, Response::HTTP_OK);
    }

}
