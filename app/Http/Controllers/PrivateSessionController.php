<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateSession\PrivateSession1;
use App\Http\Requests\PrivateSession\PrivateSession2;
use App\Http\Requests\Session\Session1;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use App\Models\PrivateSession;
use App\Models\FakeReservation;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function showAdvancedUsersInterviews(Service $service, User $user)
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

    public function create(Session1 $request, Service $service, PrivateSession1 $privateRequest)
    {
        DB::beginTransaction();
        try {
            $userID = Auth::id();
            $sessionData = array_merge($request->validated(), [
                'userID' => $userID,
                'serviceID' => $service->id,

            ]);
            $session = Session::create($sessionData);

            $privateSessionData = array_merge($privateRequest->validated(), ['sessionID' => $session->id]);
            $privateSession = PrivateSession::create($privateSessionData);
            $reservations = $this->createFakeReservations($session);


            DB::commit();

            if (request()->is('api/*')) {
                return response()->json(['session' => $session, 'privateSession' => $privateSession, 'fakeReservations' => $reservations], 200);
            }

            return view('', compact('session', 'privateSession', 'reservations'));

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->is('api/*')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function start(PrivateSession $privateSession)
    {
        $session = $privateSession->session;
        $session->update(['status'=>'active']);
        if(request()->is('api/*')) {
            return response()->json($session, 200);
        }

        return view('');
    }


    public function close(PrivateSession $privateSession)
    {
        $session=$privateSession->session;
        $session->update(['status'=>'closed']);
        if(request()->is('api/*')) {
            return response()->json($session, 200);
        }
        return view('');
    }


    public function cancel(PrivateSession $privateSession)
    {
        $session=$privateSession->session;
        $session->delete();

        if(request()->is('api/*')) {
            return response()->json(['message'=>'session canceled successfully'], 200);
        }

        return view('');
    }

    public function update(PrivateSession2 $request, Session $session)
    {
        DB::beginTransaction();
        try {
            $sessionData = $request->only(['sessionName', 'sessionDescription', 'sessionDate', 'sessionStartTime', 'sessionEndTime']);
            $privateSessionData = $request->only(['durationForEachReservation']);

            $updated = false;

            if (!empty($sessionData)) {
                $session->update($sessionData);
                $updated = true;
            }
            $privateSession = $session->privateSession;

            if ($privateSession && !empty($privateSessionData)) {
                $privateSession->update($privateSessionData);
                $updated = true;
            }

            if ($updated && ($request->has('sessionStartTime') || $request->has('sessionEndTime') || $request->has('durationForEachReservation'))) {
                FakeReservation::where('privateSessionID', $privateSession->id)->delete();
                $this->createFakeReservations($session);
            }

            DB::commit();

            if (request()->is('api/*')) {
                return response()->json(['session' => $session, 'privateSession' => $privateSession, 'fakeReservations' => $session->privateSession->fakeReservations], 200);
            }

            return view('');

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->is('api/*')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
