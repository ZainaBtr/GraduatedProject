<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\Service1;
use App\Http\Requests\Service\Service2;
use App\Http\Requests\Service\Service3;
use App\Http\Requests\Service\Service4;
use App\Models\Service;
use App\Models\ServiceManager;
use App\Models\ServiceYearAndSpecialization;
use Illuminate\Http\Response;

class ServiceController extends Controller
{

    public function showServiceNameForDynamicDropDown()
    {
        $allRecords = Service::all()
            ->unique()
            ->values();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showServiceYearAndSpecForDynamicDropDown()
    {
        $allRecords = ServiceYearAndSpecialization::all()
            ->unique()
            ->values();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAllParent()
    {
        $allRecords = Service::with(['serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.advancedUser.user', 'assignedService.assignedRole.role', 'interestedService'])
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);
        return view('pages.PublicServicesInHomePageForServiceManager',compact('allRecords'));


        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);

        }

        return view('pages.PublicServicesInHomePageForServiceManager',compact('allRecords'));

    }

    public function showChild(Service $service)
    {
        $allRecords = Service::with(['serviceManager.user', 'parentService', 'serviceYearAndSpecialization', 'assignedService.advancedUser.user', 'assignedService.assignedRole.role', 'interestedService'])
            ->where('parentServiceID', $service['id'])
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);
        return view('pages.PrivateServicesInHomePageForServiceManager', [
            'allRecords' => $allRecords,
            'parentService' => $service
        ]);
       
        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);

        }

        return view('pages.PrivateServicesInHomePageForServiceManager', [
            'allRecords' => $allRecords,
            'parentService' => $service
        ]);

    }

    public function showMyAllParentFromServiceManager()
    {
        $allRecords = Service::whereHas('serviceManager', function ($query) {
            $query->where('userID', auth()->id());
        })
            ->whereNull('parentServiceID')
            ->orderByDesc('services.status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);
        return view('pages.MyPublicServicesInHomePageForServiceManager',compact('allRecords'));

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }

        return view('pages.MyPublicServicesInHomePageForServiceManager',compact('allRecords'));

    }

    public function showMyChildFromServiceManager(Service $service)
    {
        $allRecords = Service::whereHas('serviceManager', function ($query) {
            $query->where('userID', auth()->id());
        })
            ->where('parentServiceID', $service['id'])
            ->orderByDesc('services.status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }

        return view('pages.MyPrivateServicesInHomePageForServiceManager', [
            'allRecords' => $allRecords,
            'parentService' => $service
        ]);

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

    public function showMyFromAdvancedUser()
    {
        $allData = Service::whereHas('assignedService.advancedUser', function ($query) {
            $query->where('userID', auth()->id());
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
        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAdvancedUsersOfService(Service $service)
    {
        $allRecords = $service->assignedService->map(function ($assignedService) {
            return [
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
       
        return redirect()->back();
      
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
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            Service::query()->delete();

            return response()->json(['message' => 'all records deleted successfully']);
        }
        return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
    }

    public function searchForServiceManager(Service3 $request)
    {
        $allRecords = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')
            ->whereNull('parentServiceID')
            ->orderByDesc('status')
            ->get();

        $allRecords = $this->getServiceData($allRecords);
        return view('pages.PublicServicesInHomePageForServiceManager', compact('allRecords'));
        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.PublicServicesInHomePageForServiceManager', compact('allRecords'));
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

        return response()->json($allRecords, Response::HTTP_OK);
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
        $allRecords = $this->getServiceData($query->get());

        return response()->json($allRecords, Response::HTTP_OK);
    }

}
