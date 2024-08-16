<?php

namespace App\Http\Controllers;

use App\Models\PublicReservation;
use App\Models\PublicSession;
use App\Services\PublicReservationService;

class PublicReservationController extends Controller
{
    protected $publicReservationService;

    public function __construct(PublicReservationService $publicReservationService)
    {
        $this->publicReservationService = $publicReservationService;
    }

    public function showAll(PublicSession $session)
    {
        return $this->publicReservationService->showAll($session);
    }


    public function showMyActivities()
    {
        return $this->publicReservationService->showMyActivities();
    }

    public function showMyExams()
    {
        return $this->publicReservationService->showMyExams();
    }

    public function book(PublicSession $publicSession)
    {
        return $this->publicReservationService->book($publicSession);
    }

    public function cancel(PublicReservation $publicReservation)
    {
        return $this->publicReservationService->cancel($publicReservation);
    }
}
