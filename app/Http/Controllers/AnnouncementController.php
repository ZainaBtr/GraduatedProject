<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\Announcement1;
use App\Models\Announcement;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{

    public function showAll()
    {
        $allRecords = Announcement::all();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAllFromService(Service $service)
    {
        $allRecords = Announcement::where('serviceID', $service['id'])->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showMy()
    {
        $id = auth()->id();

        $allRecords = Announcement::where('serviceManagerID', $id)->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showServiceNameForFilter()
    {
        //
    }

    public function showServiceYearForFilter()
    {
        //
    }

    public function showServiceSpecializationForFilter()
    {
        //
    }

    public function showServiceTypeForFilter()
    {
        //
    }

    public function filterByServiceName()
    {
        //
    }

    public function filterByServiceYear()
    {
        //
    }

    public function filterByServiceSpecialization()
    {
        //
    }

    public function filterByServiceType()
    {
        //
    }

    public function add(Announcement1 $request, Service $service)
    {
        $data = $request->validated();

        $data['serviceID'] = $service['id'];

        $recordStored = Service::create($data);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function update(Announcement1 $request, Announcement $announcement)
    {
        $recordUpdated = $announcement->update($request->validated());

        return response()->json($recordUpdated, Response::HTTP_OK);
    }

}
