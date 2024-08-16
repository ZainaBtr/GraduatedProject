<?php

namespace App\Http\Controllers;

use App\Models\PrivateSession;
use App\Services\FakeReservationService;

class FakeReservationController extends Controller
{
    protected $fakeReservationService;

    public function __construct(FakeReservationService $fakeReservationService)
    {
        $this->fakeReservationService = $fakeReservationService;
    }

    public function showALl(PrivateSession $privateSession)
    {
        return $this->fakeReservationService->showALl($privateSession);
    }
}
