<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateSession\PrivateSession1;
use App\Http\Requests\PrivateSession\PrivateSession2;
use App\Http\Requests\Session\Session1;
use App\Models\PrivateSession;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use App\Services\PrivateSessionService;

class PrivateSessionController extends Controller
{
    protected $privateSessionService;

    public function __construct(PrivateSessionService $privateSessionService)
    {
        $this->privateSessionService = $privateSessionService;
    }

    public function showProjectInterviews(Service $service)
    {
        $privateSession =$this->privateSessionService->showProjectInterviews($service);

        if (request()->is('api/*')) {

            return response()->json($privateSession, 200);
        }
        return view('', compact('privateSession'));
    }

    public function showAdvancedUsersInterviews(Service $service, User $user)
    {
        $privateSession =$this->privateSessionService->showAdvancedUsersInterviews($service, $user);

        if (request()->is('api/*')) {

            return response()->json($privateSession, 200);
        }
        return view('', compact('privateSession'));
    }

    public function create(Session1 $request, PrivateSession1 $privateRequest, Service $service)
    {
        try {
            $response = $this->privateSessionService->create($request, $privateRequest, $service);

            if (request()->is('api/*')) {

                return response()->json($response);
            }
            return redirect()->back();
        }
        catch (\Exception $e) {

            if (request()->is('api/*')) {

                return response()->json(['error' => $e->getMessage()], 500);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(PrivateSession2 $request, Session $session)
    {
        try {
            $response = $this->privateSessionService->update($request, $session);

            if (request()->is('api/*')) {

                return response()->json($response);
            }
            return redirect()->back();
        }
        catch (\Exception $e) {

            if (request()->is('api/*')) {

                return response()->json(['error' => $e->getMessage()], 500);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function start(PrivateSession $privateSession)
    {
        $result = $this->privateSessionService->start($privateSession);

        if(request()->is('api/*')) {

            return response()->json($result, 200);
        }
        return redirect()->back();
    }

    public function close(PrivateSession $privateSession)
    {
        $result = $this->privateSessionService->close($privateSession);

        if(request()->is('api/*')) {

            return response()->json($result, 200);
        }
        return redirect()->back();
    }

    public function cancel(PrivateSession $privateSession)
    {
        $response = $this->privateSessionService->cancel($privateSession);

        if(request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
