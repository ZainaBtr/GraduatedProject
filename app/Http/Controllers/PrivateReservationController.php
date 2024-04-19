<?php

namespace App\Http\Controllers;

use App\Models\FakeReservation;
use App\Models\PraivateReservation;
use App\Models\PrivateSession;
use Illuminate\Http\Request;

class PrivateReservationController extends Controller
{

    public function DSshowPrivateReservations(PrivateSession $privateSession)
    {
        //
    }

    public function SshowMyActivitiesPrivateReservations()
    {
        //
    }

    public function SshowMyExamsPrivateReservations()
    {
        //
    }

    public function showPrivateReservationsAttendace(PrivateSession $privateSession)
    {
        //
    }

    public function showAskedSwitch()
    {
        //
    }

    public function showSentSwitch()
    {
        //
    }

    public function bookPrivateReservation(FakeReservation $fakeReservation)
    {
        //
    }

    public function delayReservation(Request $request, PraivateReservation $praivateReservation)
    {
        //
    }

    public function deletePrivateReseravation(PraivateReservation $praivateReservation)
    {
        //
    }

    public function switchPrivateReservation(PraivateReservation $praivateReservation)
    {
        //
    }

    public function acceptPrivateReservation(PraivateReservation $praivateReservation)
    {
        //
    }

    public function declinePrivateReservation(PraivateReservation $praivateReservation)
    {
        //
    }

    public function updatePrivateReservation(PraivateReservation $praivateReservation)
    {
        //
    }

}
