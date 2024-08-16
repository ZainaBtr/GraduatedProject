<?php

namespace App\Services;

use App\Http\Requests\PrivateReservation\PrivateReservation1;
use App\Models\AssignedService;
use App\Models\FakeReservation;
use App\Models\PrivateReservation;
use App\Models\PrivateSession;
use App\Models\SwapRequest;
use App\Models\TeamMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivateReservationService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showAll(PrivateSession $privateSession)
    {
        $privateReservations = PrivateReservation::where('privateSessionID', $privateSession->id)->get();

        $reservationsDetails = $privateReservations->map(function ($reservation) {

            $groupMembers = TeamMember::where('groupID', $reservation->groupID)->with('normalUser.user')->get();

            $memberNames = $groupMembers->map(function ($member) {

                return $member->normalUser->user->fullName;
            });
            return [
                'privateReservationID' => $reservation->id,
                'groupID' => $reservation->groupID,
                'groupMembers' => $memberNames,
                'reservationDate' => $reservation->reservationDate,
                'reservationStartTime' => $reservation->reservationStartTime,
                'reservationEndTime' => $reservation->reservationEndTime,
                'privateReservationStatus' => $reservation->privateReservationStatus,
            ];
        });
        return $reservationsDetails;
    }

    public function showAttendance(PrivateSession $privateSession)
    {
        $privateReservations = PrivateReservation::where('privateSessionID', $privateSession->id)
            ->where('privateReservationStatus', true)
            ->with(['group.teamMembers.normalUser.user'])
            ->get();

        $attendanceDetails = $privateReservations->map(function ($reservation) {

            $groupMembers = $reservation->group->teamMembers->map(function ($teamMember) {

                return $teamMember->normalUser->user->fullName;
            });
            return [
                'reservationID' => $reservation->id,
                'reservationDate' => $reservation->reservationDate,
                'reservationStartTime' => $reservation->reservationStartTime,
                'reservationEndTime' => $reservation->reservationEndTime,
                'groupMembers' => $groupMembers,
            ];
        });
        return $attendanceDetails;
    }

    public function showMy()
    {
        $user = Auth::user();

        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->get();

        if ($teamMember->isEmpty()) {

            return ['message' => 'You are not part of any team.'];
        }
        $groupIDs = $teamMember->pluck('groupID');

        $privateReservations = PrivateReservation::whereIn('groupID', $groupIDs)
            ->with(['privateSession.session.service', 'group'])
            ->get();

        $reservationDetails = $privateReservations->map(function ($reservation) {

            $serviceName = $reservation->privateSession->session->service->serviceName;

            $parentServiceName = $reservation->privateSession->session->service->parentService->serviceName ?? null;

            if ($parentServiceName) {

                $serviceName = $parentServiceName . ' - ' . $serviceName;
            }
            return [
                'reservationID' => $reservation->id,
                'reservationDate' => $reservation->reservationDate,
                'reservationStartTime' => $reservation->reservationStartTime,
                'reservationEndTime' => $reservation->reservationEndTime,
                'privateReservationStatus' => $reservation->privateReservationStatus,
                'serviceName' => $serviceName,
            ];
        });
        return $reservationDetails;
    }

    public function showSentSwitch()
    {
        $user = Auth::user();

        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();

        if (!$teamMember) {

            return ['message' => 'You are not part of any team.'];
        }
        $sentSwapRequests = SwapRequest::where('senderGroupID', $teamMember->groupID)
            ->with(['privateReservation.privateSession.session.service.parentService'])
            ->get();

        return $this->controllerService->getSwapRequestsDetails($sentSwapRequests);
    }

    public function showAskedSwitch()
    {
        $user = Auth::user();

        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();

        if (!$teamMember) {

            return ['message' => 'You are not part of any team.'];
        }
        $receivedSwapRequests = SwapRequest::where('receiverGroupID', $teamMember->groupID)
            ->with(['privateReservation.privateSession.session.service.parentService'])
            ->get();

        return $this->controllerService->getSwapRequestsDetails($receivedSwapRequests);
    }

    public function book($id)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $fakeReservation = FakeReservation::find($id);

            if (!$fakeReservation) {

                return ['message' => 'This time slot is no longer available.'];
            }
            $privateSession = $fakeReservation->privateSession;
            $session = $privateSession->session;
            $serviceID = $session->serviceID;
            $reservationDate = $session->sessionDate;

            $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)
                ->whereHas('group', function ($query) use ($serviceID) {
                    $query->where('serviceID', $serviceID);
                })->first();

            if (!$teamMember) {

                return response()->json(['message' => 'You are not part of any group for this service.'], 403);
            }
            $groupID = $teamMember->groupID;

            $existingReservation = PrivateReservation::where('privateSessionID', $fakeReservation->privateSessionID)
                ->where('groupID', $groupID)->first();

            if ($existingReservation) {

                return response()->json(['message' => 'Your group already has a reservation for this session.'], 403);
            }
            $privateReservation = PrivateReservation::create([
                'groupID' => $groupID,
                'privateSessionID' => $fakeReservation->privateSessionID,
                'reservationDate' => $reservationDate,
                'reservationStartTime' => $fakeReservation->reservationStartTime,
                'reservationEndTime' => $fakeReservation->reservationEndTime,
            ]);
            $fakeReservation->delete();

            DB::commit();

            return [
                'message' => 'Your reservation has been completed successfully',
                'reservation' => $privateReservation
            ];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function delay(PrivateReservation1 $request, PrivateReservation $privateReservation)
    {
        $newReservationDate = $request->input('reservationDate');
        $newReservationStartTime = $request->input('reservationStartTime');
        $newReservationEndTime = $request->input('reservationEndTime');

        $newReservationStartDateTime = Carbon::parse($newReservationDate . ' ' . $newReservationStartTime);
        $newReservationEndDateTime = Carbon::parse($newReservationDate . ' ' . $newReservationEndTime);

        $assignedService = AssignedService::whereHas('service.session.privateSession.privateReservation', function ($query) use ($privateReservation) {
            $query->where('id', $privateReservation->id);})->first();

        if (!$assignedService) {

            return response()->json(['message' => 'No assigned service found for this reservation.'], 404);
        }
        $userID = $assignedService->userID;

        $conflictingReservation = PrivateReservation::whereHas('privateSession.session.service.assignedService', function ($query) use ($userID) {
            $query->where('userID', $userID);
        })
            ->whereDate('reservationDate', $newReservationDate)
            ->where(function ($query) use ($newReservationStartDateTime, $newReservationEndDateTime) {
                $query->whereBetween('reservationStartTime', [$newReservationStartDateTime, $newReservationEndDateTime])
                    ->orWhereBetween('reservationEndTime', [$newReservationStartDateTime, $newReservationEndDateTime])
                    ->orWhere(function ($query) use ($newReservationStartDateTime, $newReservationEndDateTime) {
                        $query->where('reservationStartTime', '<', $newReservationStartDateTime)
                            ->where('reservationEndTime', '>', $newReservationEndDateTime);});})->first();

        if ($conflictingReservation) {

            $serviceName = $conflictingReservation->privateSession->session->service->serviceName;

            $parentServiceName = $conflictingReservation->privateSession->session->service->parentService->serviceName ?? null;

            if ($parentServiceName) {

                $serviceName = $parentServiceName . ' - ' . $serviceName;
            }
            return response()->json([
                'message' => 'The new reservation time conflicts with an existing reservation.',
                'reservationID' => $conflictingReservation->id,
                'sessionName' => $conflictingReservation->privateSession->session->sessionName,
                'serviceName' => $serviceName,
                'sessionDate' => $conflictingReservation->privateSession->session->sessionDate,
                'sessionStartTime' => $conflictingReservation->privateSession->session->sessionStartTime,
                'sessionEndTime' => $conflictingReservation->privateSession->session->sessionEndTime,
            ], 409);
        }

        DB::beginTransaction();

        try {
            $privateReservation->reservationDate = $request['reservationDate'];
            $privateReservation->reservationStartTime =$request['reservationStartTime'];
            $privateReservation->reservationEndTime = $request['reservationEndTime'];
            $privateReservation->save();

            DB::commit();

            return ['message' => 'Reservation delayed successfully.'];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function delete(PrivateReservation $privateReservation)
    {
        $currentTime = now();

        $reservationStartDateTime = Carbon::parse($privateReservation->reservationDate . ' ' . $privateReservation->reservationStartTime);

        if ($currentTime->lt($reservationStartDateTime)) {

            DB::beginTransaction();

            try {
                $privateSessionID = $privateReservation->privateSessionID;
                $reservationStartTime = $privateReservation->reservationStartTime;
                $reservationEndTime = $privateReservation->reservationEndTime;

                $existingReservation = PrivateReservation::find($privateReservation->id);

                if (!$existingReservation) {

                    DB::rollBack();

                    return ['message' => 'Reservation not found.'];
                }
                $existingReservation->delete();

                FakeReservation::create([
                    'privateSessionID' => $privateSessionID,
                    'reservationStartTime' => $reservationStartTime,
                    'reservationEndTime' => $reservationEndTime,
                ]);
                DB::commit();

                return ['message' => 'Reservation deleted and slot is now available for booking.'];
            }
            catch (\Exception $e) {

                DB::rollBack();

                throw $e;
            }
        }
        else {
            return ['message' => 'Cannot delete reservation that has already started.'];
        }
    }

    public function switch($receiverGroupReservationID)
    {
        $user = Auth::user();

        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();

        if (!$teamMember) {

            return ['message' => 'You are not part of any team.'];
        }
        $senderReservation = PrivateReservation::where('groupID', $teamMember->groupID)->first();

        if (!$senderReservation) {

            return ['message' => 'No reservation found for your team.'];
        }
        $receiverReservation = PrivateReservation::find($receiverGroupReservationID);

        if (!$receiverReservation) {

            return ['message' => 'No reservation found for the receiver team.'];
        }
        $existingSwapRequest = SwapRequest::where('privateReservationID', $senderReservation->id)
            ->where('receiverGroupID', $receiverReservation->groupID)
            ->first();

        if ($existingSwapRequest) {
            return ['message' => 'Swap request already exists.'];
        }
        $swapRequest = SwapRequest::create([
            'privateReservationID' => $senderReservation->id,
            'senderGroupID' => $teamMember->groupID,
            'receiverGroupID' => $receiverReservation->groupID,
            'status' => 'pending'
        ]);
        return ['message' => 'Swap request sent successfully.', 'swapRequest' => $swapRequest];
    }

    public function accept($swapRequestID)
    {
        $swapRequest = SwapRequest::find($swapRequestID);

        if (!$swapRequest) {

            return ['message' => 'Swap request not found.'];
        }
        DB::transaction(function () use ($swapRequest) {

            $senderReservation = $swapRequest->privateReservation;

            $receiverReservation = PrivateReservation::where('groupID', $swapRequest->receiverGroupID)->first();

            if (!$receiverReservation) {

                throw new \Exception('Receiver reservation not found.');
            }
            $tempReservationDate = $senderReservation->reservationDate;
            $tempReservationStartTime = $senderReservation->reservationStartTime;
            $tempReservationEndTime = $senderReservation->reservationEndTime;

            $senderReservation->reservationDate = $receiverReservation->reservationDate;
            $senderReservation->reservationStartTime = $receiverReservation->reservationStartTime;
            $senderReservation->reservationEndTime = $receiverReservation->reservationEndTime;

            $receiverReservation->reservationDate = $tempReservationDate;
            $receiverReservation->reservationStartTime = $tempReservationStartTime;
            $receiverReservation->reservationEndTime = $tempReservationEndTime;

            $senderReservation->save();
            $receiverReservation->save();
            $swapRequest->delete();
        });
        return ['message' => 'Swap request accepted successfully.'];
    }

    public function decline($swapRequestID)
    {
        $swapRequest = SwapRequest::find($swapRequestID);

        if (!$swapRequest) {

            return ['message' => 'Swap request not found.'];
        }
        if ($swapRequest->status !== 'pending') {

            return ['message' => 'Only pending swap requests can be rejected.'];
        }
        $swapRequest->delete();

        return ['message' => 'Swap request rejected successfully.'];
    }

    public function cancelSwapReservation($swapRequestID)
    {
        $user = Auth::user();

        $swapRequest = SwapRequest::find($swapRequestID);

        if (!$swapRequest) {

            return ['message' => 'Swap request not found.'];
        }
        if ($swapRequest->status !== 'pending') {

            return ['message' => 'Only pending swap requests can be cancelled.'];
        }
        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)
            ->where('groupID', $swapRequest->senderGroupID)->first();

        if (!$teamMember) {
            return ['message' => 'You are not authorized to cancel this swap request.'];
        }
        $swapRequest->delete();

        return ['message' => 'Swap request cancelled successfully.'];
    }

    public function markAsAttendance(PrivateReservation $privateReservation)
    {
        $privateReservation->update(['privateReservationStatus'=>true]);

        return ['message' => 'attendance registered successfully'];
    }
}
