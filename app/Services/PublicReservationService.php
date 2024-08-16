<?php

namespace App\Services;

use App\Models\PublicReservation;
use App\Models\PublicSession;
use Illuminate\Support\Facades\Auth;

class PublicReservationService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showAll(PublicSession $session)
    {
        $reservations = $session->reservations;

        $userNames = $reservations->map(function ($reservation) {

            return $reservation->user->fullName;
        });
        return ['userNames' => $userNames];
    }

    public function showMyActivities()
    {
        return $this->controllerService->showMyReservationsByType('activities');
    }

    public function showMyExams()
    {
        return $this->controllerService->showMyReservationsByType('exams');
    }

    public function book(PublicSession $publicSession)
    {
        $userID = Auth::id();

        $existingReservation = PublicReservation::where('publicSessionID', $publicSession->id)
            ->where('userID', $userID)->first();

        if ($existingReservation) {

            return ['message' => 'You already have a reservation for this session.'];
        }
        $currentReservationsCount = PublicReservation::where('publicSessionID', $publicSession->id)->count();

        if ($currentReservationsCount >= $publicSession->MaximumNumberOfReservations) {

            return ['message' => 'Sorry, the count has completed.'];
        }
        $publicReservation = PublicReservation::create([
            'userID' => $userID,
            'publicSessionID' => $publicSession->id
        ]);
        return [
            'message' => 'Your reservation has been completed successfully.',
            'publicReservation'=>$publicReservation
        ];
    }

    public function cancel(PublicReservation $publicReservation)
    {
        $userID = Auth::id();

        if ($publicReservation->userID != $userID) {

            return ['message' => 'You do not have permission to cancel this reservation.'];
        }
        $publicReservation->delete();

        return ['message' => 'Your reservation has been canceled successfully.'];
    }
}
