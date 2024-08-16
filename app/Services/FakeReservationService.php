<?php

namespace App\Services;

use App\Models\PrivateSession;

class FakeReservationService
{
    public function showALl(PrivateSession $privateSession)
    {
        return $privateSession->fakeReservation;
    }
}
