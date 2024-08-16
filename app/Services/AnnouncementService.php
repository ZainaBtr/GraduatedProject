<?php

namespace App\Services;

use App\Http\Requests\Announcement\Announcement1;
use App\Http\Requests\Announcement\Announcement2;
use App\Http\Requests\Service\Service4;
use App\Models\Announcement;
use App\Models\Service;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Support\Facades\Notification;

class AnnouncementService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showAll()
    {
        $allRecords = Announcement::with('service', 'file')->get();

        return $this->controllerService->getAnnouncementData($allRecords);
    }

    public function showAllFromService(Service $service)
    {
        $allRecords = Announcement::where('serviceID', $service['id'])->with('service', 'file')->get();

        return $this->controllerService->getAnnouncementData($allRecords);
    }

    public function showMy()
    {
        $allRecords = Announcement::where('userID', auth()->id())->with('service', 'file')->get();

        return $this->controllerService->getAnnouncementData($allRecords);
    }

    public function add(Announcement1 $request)
    {
        $data = $request->validated();

        $data['userID'] = auth()->id();

        $announcement = Announcement::create($data);

        if($request['file']) {

            $announcement['fileStored'] = $this->controllerService->addFileInAnnouncement($request,  $announcement);
        }

        //////////////////// Send notification to all users except the one with id=1

        $users = User::where('id', '!=', 1)->get();

        Notification::send($users, new AnnouncementNotification($announcement));

        return auth()->user()->notifications()->latest()->first();
    }

    public function addFromService(Announcement2 $request, Service $service)
    {
        $data = $request->validated();

        $data['serviceID'] = $service['id'];

        $data['userID'] = auth()->id();

        $announcement = Announcement::create($data);

        if($request['file']) {

            $announcement['fileStored'] = $this->controllerService->addFileFromServiceInAnnouncement($request,  $announcement);
        }

        //////////////////// Send notification to all users except the one with id=1

        $users = User::where('id', '!=', 1)->get();

        Notification::send($users, new AnnouncementNotification($announcement));

        return auth()->user()->notifications()->latest()->first();
    }

    public function update(Announcement1 $request, Announcement $announcement)
    {
        return$announcement->update($request->validated());
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
        return $query->with('service', 'file')->get();
    }
}
