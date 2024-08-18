<?php

namespace App\Http\Controllers;

use App\Http\Requests\Session\Session1;
use App\Http\Requests\Session\Session2;
use App\Http\Requests\Session\Session3;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use App\Services\SessionService;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    protected $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function showActiveTheoretical()
    {
        $modifiedSessions = $this->sessionService->showActiveTheoretical();

        if (request()->is('api/*')) {

            return response()->json($modifiedSessions, Response::HTTP_OK);
        }
        return view('', compact('modifiedSessions'));
    }

    public function showActivePractical()
    {
        $modifiedSessions = $this->sessionService->showActivePractical();

        if (request()->is('api/*')) {

            return response()->json($modifiedSessions, 200);
        }
        return view('', compact('modifiedSessions'));
    }

    public function getSessionDetails($sessionID){

        $session = $this->sessionService->getSessionDetails($sessionID);

        if (request()->is('api/*')) {

            return response()->json($session, 200);
        }
        return view('', compact('session'));
    }

    public function showAll(Service $service)
    {
        $sessions = $this->sessionService->showAll($service);

        if(request()->is('api/*')) {

            return response()->json($sessions, 200);
        }
        return view('', compact('sessions'));
    }

    public function showAllRelatedToAdvancedUser(User $user)
    {
        $sessions = $this->sessionService->showAllRelatedToAdvancedUser($user);

        if (request()->is('api/*')) {

            return response()->json($sessions, 200);
        }
        return view('', compact('sessions'));
    }

    public function showMy(Service $service)
    {
        $sessions = $this->sessionService->showMy($service);

        if (request()->is('api/*')) {

            return response()->json($sessions, 200);
        }
        return view('', compact('sessions'));
    }

    public function create(Session1 $request, Service $service)
    {
        $session = $this->sessionService->create($request, $service);

        if (request()->is('api/*')) {

            return response()->json( $session, 200);
        }
        return redirect()->back();
    }

    public function update(Session2 $request, Session $session)
    {
        $updatedSession = $this->sessionService->update($request, $session);

        if (request()->is('api/*')) {

            return response()->json($updatedSession, 200);
        }
        return redirect()->back();
    }

    public function start(Session $session)
    {
        $session = $this->sessionService->start($session);

        if(request()->is('api/*')) {

            return response()->json($session, 200);
        }
        return redirect()->back();
    }

    public function close(Session $session)
    {
        $session = $this->sessionService->close($session);

        if(request()->is('api/*')) {

            return response()->json($session, 200);
        }
        return redirect()->back();
    }

    public function cancel(Session $session)
    {
        $response = $this->sessionService->cancel($session);

        if (request()->is('api/*')) {

            return response()->json($response, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function search(Session3 $request)
    {
        $searchResults = $this->sessionService->search($request);

        if ($request->is('api/*')) {

            return response()->json($searchResults, 200);
        }
        return view('', compact('searchResults'));
    }
}
