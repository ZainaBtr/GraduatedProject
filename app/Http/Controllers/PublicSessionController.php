<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicSession\PublicSession1;
use App\Http\Requests\PublicSession\PublicSession2;
use App\Http\Requests\Session\Session1;
use App\Models\AdvancedUser;
use App\Models\AssignedService;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\ServiceManager;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicSessionController extends Controller
{

    public function show(Service $service)
    {
        $publicSessions = PublicSession::with('session')
            ->whereHas('session.service', function ($query) use ($service) {
            $query->where('serviceID', $service['id']);})->get();
        if (request()->is('api/*')) {
            return response()->json($publicSessions, 200);
        }

        return view('', compact('publicSessions'));
    }


    public function create(Session1 $request, Service $service, PublicSession1 $publicSession1)
    {
        DB::beginTransaction();
        try {
            $userID = Auth::id();
            $sessionData = array_merge($request->validated(), [
                'userID' => $userID,
                'serviceID' => $service->id,
            ]);

            $session = Session::create($sessionData);

            $data = array_merge($publicSession1->validated(), ['sessionID' => $session->id]);
            $publicSession = PublicSession::create($data);

            DB::commit();

            if (request()->is('api/*')) {
                return response()->json(['session' => $session, 'publicSession' => $publicSession], 200);
            }

            return view('', compact('session', 'publicSession'));

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->is('api/*')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(PublicSession2 $request, Session $session)
    {
        DB::beginTransaction();
        try {
            // تحديث بيانات session
            $sessionData = $request->only(['sessionName', 'sessionDescription', 'sessionDate', 'sessionStartTime', 'sessionEndTime']);

            if (!empty($sessionData)) {
                $session->update($sessionData);
            }

            // تحديث بيانات public session
            $publicSessionData = $request->only(['MaximumNumberOfReservations']);
            $publicSession = $session->publicSession;

            if ($publicSession && !empty($publicSessionData)) {
                $publicSession->update($publicSessionData);
            }

            DB::commit();

            if (request()->is('api/*')) {
                return response()->json([
                    'session' => $session,
                ], 200);
            }

            return view('', compact('session', 'publicSession'));

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->is('api/*')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
