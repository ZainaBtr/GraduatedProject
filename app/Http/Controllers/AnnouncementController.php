<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\Announcement1;
use App\Http\Requests\Announcement\Announcement2;
use App\Http\Requests\Service\Service4;
use App\Models\Announcement;
use App\Models\Service;
use App\Services\AnnouncementService;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function showAll()
    {
        $allRecords = $this->announcementService->showAll();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.AdvertismentPageFromServiceForServiceManage',compact('allRecords'));
    }

    public function showAllFromService(Service $service)
    {
        $allRecords = $this->announcementService->showAllFromService($service);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('',compact('allRecords'));
    }

    public function showMy()
    {
        $allRecords = $this->announcementService->showMy();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('',compact('allRecords'));
    }

    public function add(Announcement1 $request)
    {
        $latestNotification = $this->announcementService->add($request);

        if (request()->is('api/*')) {

            return response()->json($latestNotification->data, Response::HTTP_OK);
        }
        return redirect()->back()->with(['notificationData' => $latestNotification->data]);
    }

    public function addFromService(Announcement2 $request, Service $service)
    {
        $latestNotification = $this->announcementService->addFromService($request, $service);

        if (request()->is('api/*')) {

            return response()->json($latestNotification->data, Response::HTTP_OK);
        }
        return redirect()->back()->with(['notificationData' => $latestNotification->data]);
    }

    public function update(Announcement1 $request, Announcement $announcement)
    {
        $recordUpdated = $this->announcementService->update($request, $announcement);

        if (request()->is('api/*')) {

            return response()->json($recordUpdated, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function filterByType(Service4 $request)
    {
        $filteredServices = $this->announcementService->filterByType($request);

        if (request()->is('api/*')) {

            return response()->json($filteredServices, Response::HTTP_OK);
        }
        return view('',compact('filteredServices'));
    }
}
