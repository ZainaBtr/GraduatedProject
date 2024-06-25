<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateSession\PrivateSession1;
use App\Http\Requests\PrivateSession\PrivateSession2;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use App\Models\PrivateSession;
use App\Models\FakeReservation;
use App\Models\Service;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrivateSessionController extends Controller
{

    public function showProjectInterviews(Service $service)
    {
        $privateSession = PrivateSession::with('session')
            ->whereHas('session.service', function ($query) use ($service) {
                $query->where('serviceID', $service['id']);})->get();


        if (request()->is('api/*')) {
            return response()->json($privateSession, 200);
        }

        return view('', compact('privateSession'));
    }


    public function showAdvancedUsersInterviews(Service $service, AdvancedUser $user)
    {
        $privateSession = PrivateSession::with('session')
            ->whereHas('session', function ($query) use ($service, $user) {
                $query->where('serviceID', $service->id)
                    ->where('userID', $user->id);
            })->get();

        if (request()->is('api/*')) {
            return response()->json($privateSession, 200);
        }
        return view('', compact('privateSession'));
    }



    public function create(PrivateSession1 $request, Session $session)
    {
        $privateSession = PrivateSession::create([
            'sessionID' => $session->id,
            'durationForEachReservation' => $request->input('durationForEachReservation')
        ]);
        $reservations = $this->createFakeReservations($session);

        if (request()->is('api/*')) {
            return response()->json(['privateSession' => $privateSession, 'fakeReservations' => $reservations], 201);
        }

        return view('', compact('privateSession', 'reservations'));
    }



    public function update(PrivateSession2 $request, PrivateSession $privateSession)
    {
        $privateSession->update([
            'durationForEachReservation' => $request['durationForEachReservation'],
        ]);
        $session = $privateSession->session;

        FakeReservation::where('privateSessionID', $privateSession->id)->delete();

        $this->createFakeReservations($session);

        return response()->json(['session'=>$session,
            'privateSession'=>$session->privateSession,
            'fakeReservation'=>$session->privateSession->fakeReservation]);
    }

}
