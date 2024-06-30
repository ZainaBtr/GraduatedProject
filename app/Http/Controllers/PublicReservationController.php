<?php

namespace App\Http\Controllers;

use App\Models\PublicReservation;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicReservationController extends Controller
{

    public function showAll(PublicSession $session)
    {
        $reservations = $session->reservations;
        $userNames = $reservations->map(function ($reservation) {
            return $reservation->user->fullName;
        });

        return response()->json(['userNames' => $userNames], 200);
    }


    public function showMyReservationsByType($serviceType)
    {
        $userID = Auth::id();

        $services = Service::where('serviceType', $serviceType)->pluck('id');

        $publicSessions = PublicSession::whereHas('session', function ($query) use ($services) {
            $query->whereIn('serviceID', $services);})->pluck('id');

        $myReservations = PublicReservation::where('userID', $userID)->whereIn('publicSessionID', $publicSessions)
            ->with(['publicSession.session.service.parentService'])->get();

        $reservationsDetails = $myReservations->map(function ($reservation) {
            $serviceName = $reservation->publicSession->session->service->serviceName;
            $parentServiceName = $reservation->publicSession->session->service->parentService->serviceName ?? null;

            if ($parentServiceName) {
                $serviceName = $parentServiceName . ' - ' . $serviceName;
            }

            return [
                'reservationID' => $reservation->id,
                'sessionName' => $reservation->publicSession->session->sessionName,
                'serviceName' => $serviceName,
                'sessionDate' => $reservation->publicSession->session->sessionDate,
                'sessionStartTime' => $reservation->publicSession->session->sessionStartTime,
                'sessionEndTime' => $reservation->publicSession->session->sessionEndTime,
            ];
        });

        return response()->json($reservationsDetails, 200);
    }


    public function showMyActivities()
    {
        return $this->showMyReservationsByType('Activity');
    }


    public function showMyExams()
    {
        return $this->showMyReservationsByType('Exam');
    }


    public function book(PublicSession $publicSession)
    {
        $userID = Auth::id();
        $existingReservation = PublicReservation::where('publicSessionID', $publicSession->id)
            ->where('userID', $userID)->first();

        if ($existingReservation) {
            return response()->json([
                'message' => 'You already have a reservation for this session.'], 400);
        }

        $currentReservationsCount = PublicReservation::where('publicSessionID', $publicSession->id)->count();
        if ($currentReservationsCount >= $publicSession->MaximumNumberOfReservations) {
            return response()->json([
                'message' => 'Sorry, the count has completed.'], 403);
        }
         $publicReservation = PublicReservation::create([
            'userID' => $userID,
            'publicSessionID' => $publicSession->id
        ]);

        return response()->json([
            'message' => 'Your reservation has been completed successfully.',
            'publicReservation'=>$publicReservation
        ], 200);
    }


    public function cancel(PublicReservation $publicReservation)
    {
        $userID = Auth::id();

        if ($publicReservation->userID != $userID) {
            return response()->json([
                'message' => 'You do not have permission to cancel this reservation.'
            ], 403);
        }

        $publicReservation->delete();

        return response()->json([
            'message' => 'Your reservation has been canceled successfully.'], 200);
    }


}
