<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateReservation\PrivateReservation1;
use App\Models\FakeReservation;
use App\Models\PrivateReservation;
use App\Models\PrivateSession;
use Illuminate\Http\Request;

class PrivateReservationController extends Controller
{

    public function showAll(PrivateSession $privateSession)
    {
        //
    }

    public function showMyActivities()
    {
        //
    }

    public function showMyExams()
    {
        //
    }

    public function showAttendance(PrivateSession $privateSession)
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

    public function book(FakeReservation $fakeReservation)
    {
        //
    }

    public function delay(PrivateReservation1 $request, PrivateReservation $privateReservation)
    {
        //
    }

    public function delete(PrivateReservation $privateReservation)
    {
        //
    }

    public function switch(PrivateReservation $privateReservation)
    {
        //
    }

    public function accept(PrivateReservation $privateReservation)
    {
        //
    }

    public function decline(PrivateReservation $privateReservation)
    {
        //
    }

    public function update(PrivateReservation $privateReservation)
    {
        //
    }

}
