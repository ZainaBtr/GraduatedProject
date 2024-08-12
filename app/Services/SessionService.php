<?php

namespace App\Services;

use App\Http\Requests\Session\Session1;
use App\Http\Requests\Session\Session2;
use App\Http\Requests\Session\Session3;
use App\Models\FakeReservation;
use App\Models\PrivateReservation;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SessionService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->$controllerService = $controllerService;
    }

    public function getActiveTheoreticalSessions()
    {
        $activeSessions = Session::whereHas('service', function ($query) {
            $query->where('serviceName', 'theoretical');
        })->where('status', 'active')
            ->with('service:id,serviceName,parentServiceID', 'service.parentService:id,serviceName')
            ->get();

        return $activeSessions->map(function ($session) {
            return [
                'sessionID' => $session->id,
                'serviceID' => $session->service->id,
                'parentServiceName' => $session->service->parentService->serviceName ?? 'No Parent Service',
            ];
        });
    }

    public function getActivePracticalSessions()
    {
        $activeSessions = Session::whereHas('service', function ($query) {
            $query->where('serviceName', 'practical');
        })->where('status', 'active')
            ->with('service:id,serviceName,parentServiceID', 'service.parentService:id,serviceName')
            ->get();

        return $activeSessions->map(function ($session) {
            return [
                'sessionID' => $session->id,
                'serviceID' => $session->service->id,
                'parentServiceName' => $session->service->parentService->serviceName ?? 'No Parent Service',
            ];
        });
    }

    public function getSessionDetails($sessionID)
    {
        return Session::where('id', $sessionID)->first();
    }

    public function getAllSessions(Service $service)
    {
        return Session::query()->where('serviceID', $service['id'])->get()->all();
    }

    public function getSessionsRelatedToAdvancedUser(User $user)
    {
        return Session::where('userID', $user->id)->get()->all();
    }

    public function getMySessions(Service $service)
    {
        $user = Auth::user();

        return Session::where('userID', $user['id'])->where('serviceID', $service['id'])->get();
    }

    public function createSession(Session1 $request, Service $service)
    {
        $userID = Auth::id();

        $session = array_merge($request->validated(), [
            'userID' => $userID,
            'serviceID' => $service['id'],
        ]);
        return Session::create($session);
    }

    public function startSession(Session $session)
    {
        $session->update(['status' => 'active']);

        return $session;
    }

    public function closeSession(Session $session)
    {
        $session->update(['status' => 'closed']);

        return $session;
    }

    public function cancelSession(Session $session)
    {
        $session->delete();

        return ['message' => 'session canceled successfully'];
    }

    public function updateSession(Session2 $request, Session $session)
    {
        $updatedSession = $session->update($request->validated());

        $privateSession = $session->privateSession;

        if ($privateSession) {
            if ($request->has('sessionStartTime') || $request->has('sessionEndTime')) {

                FakeReservation::where('privateSessionID', $privateSession->id)->delete();

                PrivateReservation::where('privateSessionID', $privateSession->id)->delete();

                $this->controllerService->createFakeReservations($updatedSession);
            }
        }
        return $updatedSession;
    }

    public function searchSessions(Session3 $request)
    {
        $searchedServices = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')->get();

        $serviceIds = $searchedServices->pluck('id');

        return Session::whereIn('serviceID', $serviceIds)->get();
    }
}
