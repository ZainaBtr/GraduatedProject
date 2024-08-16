<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\Announcement1;
use App\Http\Requests\Announcement\Announcement2;
use App\Http\Requests\File\File1;
use App\Models\User;
use App\Services\ControllerService;
use App\Models\Announcement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\User\User4;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function sendEmail($email)
    {
        $this->controllerService->sendEmail($email);
    }

    public function createToken(User $user)
    {
        return $this->controllerService->createToken($user);
    }

    public function checkToken(User4 $request)
    {
        return $this->controllerService->checkToken($request);
    }

    public function importUsersFile(File1 $request, $importClass)
    {
         $response = $this->controllerService->importUsersFile($request, $importClass);

         if(request()->is('api/*')) {

             return response()->json($response);
         }
         return redirect()->back();
    }

    public function checkIsInterested($serviceId, $userId)
    {
        return $this->controllerService->checkIsInterested($serviceId, $userId);
    }

    public function getServiceData($allRecords)
    {
        return $this->controllerService->getServiceData($allRecords);
    }

    public function checkIsSaved($announcementId, $userId)
    {
        return $this->controllerService->checkIsSaved($announcementId, $userId);
    }

    public function getAnnouncementData($allRecords)
    {
        return $this->controllerService->getAnnouncementData($allRecords);
    }

    public function createFakeReservations($session): array
    {
        return $this->controllerService->createFakeReservations($session);
    }

    private function storeFile($request, $announcement)
    {
        return $this->controllerService->storeFile($request, $announcement);
    }

    public function addFileInAnnouncement(Announcement1 $request, Announcement $announcement)
    {
        return $this->controllerService->addFileInAnnouncement($request, $announcement);
    }

    public function addFileFromServiceInAnnouncement(Announcement2 $request, Announcement $announcement)
    {
        return $this->controllerService->addFileFromServiceInAnnouncement($request, $announcement);
    }

    public function showMyReservationsByType($serviceType)
    {
        return $this->controllerService->showMyReservationsByType($serviceType);
    }

    public function getSwapRequestsDetails($swapRequests)
    {
        return $this->controllerService->getSwapRequestsDetails($swapRequests);
    }
}
