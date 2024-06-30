<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\Announcement1;
use App\Http\Requests\Announcement\Announcement2;
use App\Http\Requests\Service\Service4;
use App\Models\Announcement;
use App\Models\Service;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{

    public function showAll()
    {
        $allRecords = Announcement::with('service', 'file')->get();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.AdvertismentPageFromServiceForServiceManage',compact('allRecords'));
    }

    public function showAllFromService(Service $service)
    {
        $allRecords = Announcement::where('serviceID', $service['id'])->with('service', 'file')->get();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('');
    }

    public function showMy()
    {
        $allRecords = Announcement::where('userID', auth()->id())->with('service', 'file')->get();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('');
    }

    public function add(Announcement1 $request)
    {
        $data = $request->validated();

        $data['userID'] = auth()->id();

        $announcement = Announcement::create($data);

        if($request['file'])
            $announcement['fileStored'] = $this->addFileInAnnouncement($request,  $announcement);
            return redirect()->back();

        if (request()->is('api/*')) {
            return response()->json($announcement, Response::HTTP_OK);
        }
        return view('');
    }

    public function addFromService(Announcement2 $request, Service $service)
    {
        $data = $request->validated();

        $data['serviceID'] = $service['id'];

        $data['userID'] = auth()->id();

        $announcement = Announcement::create($data);

        if($request['file'])
            $announcement['fileStored'] = $this->addFileFromServiceInAnnouncement($request,  $announcement);

        if (request()->is('api/*')) {
            return response()->json($announcement, Response::HTTP_OK);
        }
        return view('');
    }

    public function update(Announcement1 $request, Announcement $announcement)
    {
        $recordUpdated = $announcement->update($request->validated());

        if (request()->is('api/*')) {
            return response()->json($recordUpdated, Response::HTTP_OK);
        }
        return view('');
    }

    public function filterByType(Service4 $request)
    {
        $filterType = $request['filterType'];
        $filterName = $request['filterName'];

        $query = Announcement::query();

        if ($filterType == 'serviceYear' || $filterType == 'serviceSpecializationName') {
            $query->whereHas('service.serviceYearAndSpecialization', function ($subQuery) use ($filterType, $filterName) {
                $subQuery->where($filterType, $filterName);
            });
        }
        elseif ($filterType == 'serviceName' || $filterType == 'serviceType') {
            $query->whereHas('service', function ($subQuery) use ($filterType, $filterName) {
                $subQuery->where($filterType, $filterName);
            });
        }
        $filteredServices = $query->with('service', 'file')->get();

        if (request()->is('api/*')) {
            return response()->json($filteredServices, Response::HTTP_OK);
        }
        return view('');
    }

}
