<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\Service1;
use App\Http\Requests\Service\Service2;
use App\Http\Requests\Service\Service3;
use App\Http\Requests\Service\Service4;
use App\Models\AdvancedUser;
use App\Models\Service;
use App\Models\ServiceYearAndSpecialization;
use Illuminate\Http\Response;

class ServiceController extends Controller
{

    public function showAll()
    {
        $allRecords = Service::all();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showByYearAndSpecializationInGeneral(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        $allRecords = Service::where('serviceYearAndSpecializationID', $serviceYearAndSpecialization['id'])->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showByType($type)
    {
        $allRecords = Service::where('serviceType', $type)->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showMy()
    {
        $id = auth()->id();

        $allRecords = Service::where('serviceManagerID', $id)->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAdvancedUsersOfService(Service $service)
    {
        $allRecords = AdvancedUser::whereHas('assignedServices', function ($query) use ($service) {
            $query->where('serviceID', $service['id']);
        })->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function add(Service1 $request, ?Service $parentService)
    {
        $data = $request->validated();

        if ($parentService && $parentService->exists) {
            $data['parentServiceID'] = $parentService->id;
        }

        $recordStored = Service::create($data);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function update(Service2 $request, Service $service)
    {
        $recordUpdated = $service->update($request->validated());

        return response()->json($recordUpdated, Response::HTTP_OK);
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

    public function search(Service3 $request)
    {
        $searchResults = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')->get();

        return response()->json($searchResults, Response::HTTP_OK);
    }

    public function filterByType(Service4 $request)
    {
        $filterType = $request['filterType'];
        $filterName = $request['filterName'];

        $query = Service::query();

        $serviceYear = ServiceYearAndSpecialization::where('serviceYear', $filterName)->get();
        $serviceSpecialization = ServiceYearAndSpecialization::where('serviceSpecialization', $filterName)->get();

        if ($filterType == 'serviceYear') {
            $query->whereIn('serviceYearAndSpecializationID', $serviceYear);
        }

        if ($filterType == 'serviceSpecialization') {
            $query->whereIn('serviceYearAndSpecializationID', $serviceSpecialization);
        }

        if ($filterType == 'serviceType') {
            $query->where('serviceType', $filterName);
        }

        $filteredServices = $query->get();

        return response()->json($filteredServices, Response::HTTP_OK);
    }

}
