<?php

namespace App\Services;

use App\Http\Requests\PrivateSession\PrivateSession1;
use App\Http\Requests\PrivateSession\PrivateSession2;
use App\Http\Requests\Session\Session1;
use App\Models\FakeReservation;
use App\Models\PrivateReservation;
use App\Models\PrivateSession;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivateSessionService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showProjectInterviews(Service $service)
    {
        return PrivateSession::with('session')
            ->whereHas('session.service', function ($query) use ($service) {
                $query->where('serviceID', $service['id']);
            })->get();
    }

    public function showAdvancedUsersInterviews(Service $service, User $user)
    {
        return PrivateSession::with('session')
            ->whereHas('session', function ($query) use ($service, $user) {
                $query->where('serviceID', $service->id)
                    ->where('userID', $user->id);
            })->get();
    }

    public function create(Session1 $request, PrivateSession1 $privateRequest, Service $service)
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

            $reservations = $this->controllerService->createFakeReservations($session);

            DB::commit();

            return [
                'session' => $session,
                'privateSession' => $privateSession,
                'fakeReservations' => $reservations
            ];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
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

                PrivateReservation::where('privateSessionID', $privateSession->id)->delete();

                $this->controllerService->createFakeReservations($session);
            }

            DB::commit();

            return [
                'session' => $session,
                'privateSession' => $privateSession,
                'fakeReservations' => $session->privateSession->fakeReservations
            ];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function start(PrivateSession $privateSession)
    {
        $session = $privateSession->session;

        return $session->update(['status' => 'active']);
    }

    public function close(PrivateSession $privateSession)
    {
        $session = $privateSession->session;

        return $session->update(['status' => 'closed']);
    }

    public function cancel(PrivateSession $privateSession)
    {
        $session = $privateSession->session;

        $session->delete();

        return ['message' => 'session canceled successfully'];
    }
}
