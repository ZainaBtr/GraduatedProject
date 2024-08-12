<?php

namespace App\Services;

use App\Models\FakeReservation;
use Carbon\Carbon;

class ControllerService
{
    public function createFakeReservations($session): array
    {
        $privateSession = $session->privateSession;
        $sessionStartTime = Carbon::parse($session->sessionStartTime);
        $sessionEndTime = Carbon::parse($session->sessionEndTime);
        $durationForEachReservation = Carbon::parse($privateSession->durationForEachReservation);

        $totalSessionDurationMinutes = $sessionEndTime->diffInMinutes($sessionStartTime);
        $reservationDurationMinutes = $durationForEachReservation->hour * 60 + $durationForEachReservation->minute;
        $numberOfReservations = intval($totalSessionDurationMinutes / $reservationDurationMinutes);

        $reservations = [];
        for ($i = 0; $i < $numberOfReservations; $i++) {
            $reservationStartTime = $sessionStartTime->copy()->addMinutes($i * $reservationDurationMinutes);
            $reservationEndTime = $reservationStartTime->copy()->addMinutes($reservationDurationMinutes);

            $reservationStartTimeFormatted = $reservationStartTime->format('H:i');
            $reservationEndTimeFormatted = $reservationEndTime->format('H:i');

            $reservations[] = FakeReservation::create([
                'privateSessionID' => $privateSession->id,
                'reservationStartTime' => $reservationStartTimeFormatted,
                'reservationEndTime' => $reservationEndTimeFormatted
            ]);
        }

        return $reservations;
    }
}
