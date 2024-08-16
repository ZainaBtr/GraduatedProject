<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateReservation\PrivateReservation1;
use App\Models\PrivateReservation;
use App\Models\PrivateSession;
use App\Services\PrivateReservationService;

class PrivateReservationController extends Controller
{
    protected $privateReservationService;

    public function __construct(PrivateReservationService $privateReservationService)
    {
        $this->privateReservationService = $privateReservationService;
    }

    public function showAll(PrivateSession $privateSession)
    {
        return $this->privateReservationService->showAll($privateSession);
    }

    public function showAttendance(PrivateSession $privateSession)
    {
        return $this->privateReservationService->showAttendance($privateSession);
    }

    public function showMy()
    {
        return $this->privateReservationService->showMy();
    }

    public function showSentSwitch()
    {
        return $this->privateReservationService->showSentSwitch();
    }

    public function showAskedSwitch()
    {
        return $this->privateReservationService->showSentSwitch();
    }

    public function book($id)
    {
        try {
            return $this->privateReservationService->book($id);
        }
        catch (\Exception $e) {
          
            return response()->json(['error' => 'An error occurred while processing your reservation: ' . $e->getMessage()], 500);
        }
    }

    public function delay(PrivateReservation1 $request, PrivateReservation $privateReservation)
    {
        try {
            return $this->privateReservationService->delay($request, $privateReservation);
        }
        catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred while delaying the reservation.' . $e->getMessage()], 500);
        }
    }

    public function delete(PrivateReservation $privateReservation)
    {
        try {
            return $this->privateReservationService->delete($privateReservation);
        }
        catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred while deleting the reservation.' . $e->getMessage()], 500);
        }
    }

    public function switch($receiverGroupReservationID)
    {
        return $this->privateReservationService->switch($receiverGroupReservationID);
    }

    public function accept($swapRequestID)
    {
        return $this->privateReservationService->accept($swapRequestID);

    }

    public function decline($swapRequestID)
    {
        return $this->privateReservationService->decline($swapRequestID);
    }

        public function cancelSwapReservation($swapRequestID)
    {
        return $this->privateReservationService->cancelSwapReservation($swapRequestID);
    }

    public function markAsAttendance(PrivateReservation $privateReservation)
    {
        return $this->privateReservationService->markAsAttendance($privateReservation);
    }
}
