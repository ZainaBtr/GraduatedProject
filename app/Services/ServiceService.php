<?php

namespace App\Services;

use App\Http\Requests\Service\Service1;
use App\Http\Requests\Service\Service2;
use App\Http\Requests\Service\Service3;
use App\Http\Requests\Service\Service4;
use App\Models\Service;
use App\Models\ServiceManager;
use App\Models\ServiceYearAndSpecialization;

class ServiceService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showServiceNameForDynamicDropDown()
    {
        return Service::all()->unique()->values();
    }

    public function showServiceYearAndSpecForDynamicDropDown()
    {
        return ServiceYearAndSpecialization::all()->unique()->values();
    }

    public function showAllParent()
    {
        $allRecords = Service::with(['serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.user', 'assignedService.assignedRole.role', 'interestedService'])
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        return $this->controllerService->getServiceData($allRecords);
    }

    public function showChild(Service $service)
    {
        $allRecords = Service::with(['serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.user', 'assignedService.assignedRole.role', 'interestedService'])
            ->where('parentServiceID', $service['id'])
            ->orderByDesc('status')
            ->get();

        return $this->controllerService->getServiceData($allRecords);
    }

    public function showMyAllParentFromServiceManager()
    {
        $allRecords = Service::whereHas('serviceManager', function ($query) {
            $query->where('userID', auth()->id());
        })
            ->whereNull('parentServiceID')
            ->orderByDesc('services.status')
            ->get();

        return $this->controllerService->getServiceData($allRecords);
    }

    public function showMyChildFromServiceManager(Service $service)
    {
        $allRecords = Service::whereHas('serviceManager', function ($query) {
            $query->where('userID', auth()->id());
        })
            ->where('parentServiceID', $service['id'])
            ->orderByDesc('services.status')
            ->get();

        return $this->controllerService->getServiceData($allRecords);
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
        return $allRecords;
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
        return $allRecords;
    }

    public function showMyFromAdvancedUser()
    {
        $allData = Service::whereHas('assignedService.user', function ($query) {
            $query->where('id', auth()->id());
        })
            ->where('status', 1)
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
        return $allRecords;
    }

    public function showAdvancedUsersOfService(Service $service)
    {
        return $service->assignedService->map(function ($assignedService) {
            return [
                'id' => $assignedService->user->id,
                'fullName' => $assignedService->user->fullName,
                'roles' => $assignedService->assignedRole->pluck('role.roleName')
            ];
        });
    }

    public function add(Service1 $request, ?Service $parentService = null)
    {
        $data = $request->validated();

        $data['serviceManagerID'] = ServiceManager::where('userID', auth()->id())->value('id');

        if ($parentService && $parentService->exists) {

            $data['parentServiceID'] = $parentService['id'];
        }
        return Service::create($data);
    }

    public function update(Service2 $request, Service $service)
    {
        return $service->update($request->validated());
    }

    public function delete(Service $service)
    {
        $service->delete();

        return ['message' => 'this record deleted successfully'];
    }

    public function deleteAll()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            Service::query()->delete();

            return ['message' => 'all records deleted successfully'];
        }
        return ['message' => 'you dont have the permission to delete all records in this table'];
    }

    public function searchForServiceManager(Service3 $request)
    {
        $allRecords = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        return $this->controllerService->getServiceData($allRecords);
    }

    public function searchForAdvancedUser(Service3 $request)
    {
        $allRecords = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')
            ->whereNull('parentServiceID')
            ->where('status', 1)
            ->get();

        foreach ($allRecords as $record) {
            $record['children'] = Service::where('parentServiceID', $record['id'])
                ->where('status', 1)
                ->get();
        }
        return $allRecords;
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
        return $this->controllerService->getServiceData($query->get());
    }
}
