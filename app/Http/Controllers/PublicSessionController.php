<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicSession\PublicSession1;
use App\Http\Requests\PublicSession\PublicSession2;
use App\Http\Requests\Session\Session1;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\Session;
use App\Services\PublicSessionService;

class PublicSessionController extends Controller
{
    protected $publicSessionService;

    public function __construct(PublicSessionService $publicSessionService)
    {
        $this->publicSessionService = $publicSessionService;
    }

    public function show(Service $service)
    {
        $publicSessions = $this->publicSessionService->show($service);

        if (request()->is('api/*')) {

            return response()->json($publicSessions, 200);
        }
        return view('', compact('publicSessions'));
    }

    public function create(Session1 $request, PublicSession1 $publicSession1, Service $service)
    {
        try {
            $response = $this->publicSessionService->create($request, $publicSession1, $service);

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

    public function update(PublicSession2 $request, Session $session)
    {
        try {
            $response = $this->publicSessionService->update($request, $session);

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

    public function start(PublicSession $publicSession)
    {
        $session = $this->publicSessionService->start($publicSession);

        if(request()->is('api/*')) {

            return response()->json($session, 200);
        }
        return redirect()->back();
    }

    public function close(PublicSession $publicSession)
    {
        $session = $this->publicSessionService->close($publicSession);

        if(request()->is('api/*')) {

            return response()->json($session, 200);
        }
        return redirect()->back();
    }

    public function cancel(PublicSession $publicSession)
    {
        $response = $this->publicSessionService->cancel($publicSession);

        if(request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
