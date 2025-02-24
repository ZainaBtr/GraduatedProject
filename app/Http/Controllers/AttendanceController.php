<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Session;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $announcementService;

    public function __construct(AttendanceService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function showSessionQr(Session $session)
    {
        return $this->announcementService->showSessionQr($session);
    }

    public function showOfOneSession(Session $session)
    {
        return $this->announcementService->showOfOneSession($session);
    }

    public function showOfOneService(Service $service)
    {
        return $this->announcementService->showOfOneService($service);
    }

    public function showMyAttendanceOfOneService(Service $service)
    {
        return $this->announcementService->showMyAttendanceOfOneService($service);
    }

    public function scanQr(Request $request)
    {
        return $this->announcementService->scanQr($request);
    }

    public function showAttendanceOfOneServiceInExcel(Service $service)
    {
        return $this->announcementService->showAttendanceOfOneServiceInExcel($service);
    }

    public function showRandomQuestion()
    {
        return $this->announcementService->showRandomQuestion();
    }

    public function checkAnswer(Request $request)
    {
        return $this->announcementService->checkAnswer($request);
    }
}
