<?php

namespace App\Http\Controllers;

use App\Models\FakeReservation;
use App\Models\PrivateSession;
use Illuminate\Http\Request;

class FakeReservationController extends Controller
{

    public function showALl(PrivateSession $privateSession)
    {
        $fakeReservations = $privateSession->fakeReservation;
        return response()->json($fakeReservations, 200);
    }

}
