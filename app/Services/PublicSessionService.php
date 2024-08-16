<?php

namespace App\Services;

use App\Http\Requests\PublicSession\PublicSession1;
use App\Http\Requests\PublicSession\PublicSession2;
use App\Http\Requests\Session\Session1;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicSessionService
{
    public function show(Service $service)
    {
        return PublicSession::with('session')
            ->whereHas('session.service', function ($query) use ($service) {
                $query->where('serviceID', $service['id']);})->get();
    }

    public function create(Session1 $request, PublicSession1 $publicSession1, Service $service)
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

            return [
                'session' => $session,
                'publicSession' => $publicSession
            ];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function update(PublicSession2 $request, Session $session)
    {
        DB::beginTransaction();

        try {
            $sessionData = $request->only(['sessionName', 'sessionDescription', 'sessionDate', 'sessionStartTime', 'sessionEndTime']);

            if (!empty($sessionData)) {

                $session->update($sessionData);
            }
            $publicSessionData = $request->only(['MaximumNumberOfReservations']);

            $publicSession = $session->publicSession;

            if ($publicSession && !empty($publicSessionData)) {

                $publicSession->update($publicSessionData);
            }
            DB::commit();

            return ['session' => $session,];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function start(PublicSession $publicSession)
    {
        $session = $publicSession->session;

        return $session->update(['status'=>'active']);
    }

    public function close(PublicSession $publicSession)
    {
        $session=$publicSession->session;

        return $session->update(['status'=>'closed']);
    }

    public function cancel(PublicSession $publicSession)
    {
        $session=$publicSession->session;

        $session->delete();

        return ['message'=>'session canceled successfully'];
    }
}
