<?php

namespace App\Http\Controllers;

use App\Http\Requests\Session\Session1;
use App\Http\Requests\Session\Session2;
use App\Http\Requests\Session\Session3;
use App\Models\FakeReservation;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function showActiveTheoretical()
    {
        $activeSessions = Session::whereHas('service', function ($query) {
            $query->where('serviceName', 'theoretical');
        })->where('status', 'active')
            ->with('service:id,serviceName,parentServiceID', 'service.parentService:id,serviceName')
            ->get();

        $modifiedSessions = $activeSessions->map(function ($session) {
            return [
                'sessionID' => $session->id,
                'serviceID' => $session->service->id,
                'parentServiceName' => $session->service->parentService->serviceName ?? 'No Parent Service',
            ];
        });

        if (request()->is('api/*')) {
            return response()->json($modifiedSessions, 200);
        }
        return view('', compact('modifiedSessions'));
    }

    public function showActivePractical()
    {

        $activeSessions = Session::whereHas('service', function ($query) {
            $query->where('serviceName', 'practical');
        })->where('status', 'active')
            ->with('service:id,serviceName,parentServiceID', 'service.parentService:id,serviceName')
            ->get();

        $modifiedSessions = $activeSessions->map(function ($session) {
            return [
                'sessionID' => $session->id,
                'serviceID' => $session->service->id,
                'parentServiceName' => $session->service->parentService->serviceName ?? 'No Parent Service',
            ];
        });

        if (request()->is('api/*')) {
            return response()->json($modifiedSessions, 200);
        }
        return view('', compact('modifiedSessions'));
    }

    public function getSessionDetails($sessionID){

        $session = Session::where('id',$sessionID)->first();

        if (request()->is('api/*')) {
            return response()->json($session, 200);
        }
        return view('');
    }

    public function showAll(Service $service)
    {
        $sessions= Session::query()->where('serviceID',$service['id'])->get()->all();

        if(request()->is('api/*')) {
            return response()->json($sessions, 200);
        }

        return view('');
    }


    public function showAllRelatedToAdvancedUser(User $user)
    {

        $sessions = Session::where('userID', $user->id)->get()->all();

        if (request()->is('api/*')) {
            return response()->json($sessions, 200);
        }

        return view('', compact('sessions'));
    }


    public function showMy(Service $service)
    {
        $user = Auth::user();
        $sessions = Session::where('userID',$user['id'])
            ->where('serviceID', $service['id'])->get();

        if (request()->is('api/*')) {
            return response()->json($sessions, 200);
        }
        return view('', compact('sessions'));
    }


    public function create(Session1 $request, Service $service)
    {
        $userID=Auth::id();
        $sessionStartTime = Carbon::parse($request['sessionStartTime'])->format('H:i');
        $sessionEndTime = Carbon::parse($request['sessionEndTime'])->format('H:i');

        $session = Session::create([
            'userID'=>$userID,
            'serviceID' => $service['id'],
            'sessionName'=>$request['sessionName'],
            'sessionDescription'=>$request['sessionDescription'],
            'sessionDate'=>$request['sessionDate'],
            'sessionStartTime'=> $sessionStartTime,
            'sessionEndTime'=>$sessionEndTime,
        ]);

        if (request()->is('api/*')) {
            return response()->json( $session, 200);
        }

        return view('');
    }


    public function start(Session $session)
    {
        $session = Session::query()->where('id',$session['id'])->get()->first();
        $session->update(['status'=>'active']);
        if(request()->is('api/*')) {
            return response()->json($session, 200);
        }

        return view('');
    }


    public function close(Session $session)
    {
        $session->update(['status'=>'closed']);
        if(request()->is('api/*')) {
            return response()->json($session, 200);
        }
        return view('');
    }


    public function cancel(Session $session)
    {
        $session->delete();

        if(request()->is('api/*')) {
            return response()->json(['message'=>'session canceled successfully'], 200);
        }

        return view('');
    }


    public function update(Session2 $request, Session $session)
    {
        $updatedSession = Session::findOrFail($session->id);
        $updatedSession->update($request->validated());

        $privateSession = $session->privateSession;

        if ($privateSession) {
            if ($request->has('sessionStartTime') || $request->has('sessionEndTime')) {
                FakeReservation::where('privateSessionID', $privateSession->id)->delete();
                $this->createFakeReservations($updatedSession);
            }
        }

        if (request()->is('api/*')) {
            return response()->json($updatedSession, 200);
        }

        return view('');
    }


    public function search(Session3 $request)
    {
        $searchedServices = Service::where('serviceName', 'like', '%' . $request['serviceName'] . '%')->get();
        $serviceIds = $searchedServices->pluck('id');
        $searchResults = Session::whereIn('serviceID', $serviceIds)->get();

        if ($request->is('api/*')) {
            return response()->json($searchResults, 200);
        }
        return view('');
    }

}
