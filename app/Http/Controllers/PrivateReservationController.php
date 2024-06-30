<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateReservation\PrivateReservation1;
use App\Models\AssignedService;
use App\Models\FakeReservation;
use App\Models\PrivateReservation;
use App\Models\PrivateSession;
use App\Models\Service;
use App\Models\Session;
use App\Models\SwapRequest;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivateReservationController extends Controller
{

    public function showAll(PrivateSession $privateSession)
    {
        $privateReservations = PrivateReservation::where('privateSessionID', $privateSession->id)->get();

        $reservationsDetails = $privateReservations->map(function ($reservation) {
            $groupMembers = TeamMember::where('groupID', $reservation->groupID)->with('normalUser.user')->get();
            $memberNames = $groupMembers->map(function ($member) {
                return $member->normalUser->user->fullName; });

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

        return response()->json($reservationsDetails, 200);
    }

    public function showAttendance(PrivateSession $privateSession)
    {
         $privateReservations = PrivateReservation::where('privateSessionID', $privateSession->id)
            ->where('privateReservationStatus', true)
            ->with(['group.teamMembers.normalUser.user'])->get();

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

        return response()->json($attendanceDetails, 200);

    }

    public function showMy()
    {
        $user = Auth::user();
        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->get();

        if ($teamMember->isEmpty()) {
            return response()->json(['message' => 'You are not part of any team.'], 403);
        }
        $groupIDs = $teamMember->pluck('groupID');
        $privateReservations = PrivateReservation::whereIn('groupID', $groupIDs)
            ->with(['privateSession.session.service', 'group'])->get();

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

        return response()->json($reservationDetails, 200);

}

    protected function getSwapRequestsDetails($swapRequests)
    {
        return $swapRequests->map(function ($swapRequest) {
            $serviceName = $swapRequest->privateReservation->privateSession->session->service->serviceName;
            $parentServiceName = $swapRequest->privateReservation->privateSession->session->service->parentService->serviceName ?? '';

            return [
                'swapRequestID' => $swapRequest->id,
                'serviceName' => trim("$serviceName $parentServiceName"),
                'senderReservation' => [
                    'id' => $swapRequest->privateReservation->id,
                    'reservationDate' => $swapRequest->privateReservation->reservationDate,
                    'reservationStartTime' => $swapRequest->privateReservation->reservationStartTime,
                    'reservationEndTime' => $swapRequest->privateReservation->reservationEndTime,
                ],
                'status' => $swapRequest->status,
            ];
        });
    }

    public function showSentSwitch()
    {
        $user = Auth::user();
        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();
        if (!$teamMember) {
            return response()->json(['message' => 'You are not part of any team.'], 403);
        }
        $sentSwapRequests = SwapRequest::where('senderGroupID', $teamMember->groupID)
            ->with(['privateReservation.privateSession.session.service.parentService'])
            ->get();
        $swapRequestsDetails = $this->getSwapRequestsDetails($sentSwapRequests);
        return response()->json($swapRequestsDetails, 200);
    }

    public function showAskedSwitch()
    {
        $user = Auth::user();
        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();
        if (!$teamMember) {
            return response()->json(['message' => 'You are not part of any team.'], 403);
        }
        $receivedSwapRequests = SwapRequest::where('receiverGroupID', $teamMember->groupID)
            ->with(['privateReservation.privateSession.session.service.parentService'])
            ->get();
        $swapRequestsDetails = $this->getSwapRequestsDetails($receivedSwapRequests);
        return response()->json($swapRequestsDetails, 200);
    }

    public function book($id)
    {
        $user = Auth::user();

        $fakeReservation = FakeReservation::find($id);
        if (!$fakeReservation) {
            return response()->json(['message' => 'This time slot is no longer available.'], 404);
        }

        $privateSession = $fakeReservation->privateSession;
        $session = $privateSession->session;
        $serviceID = $session->serviceID;
        $reservationDate = $session->sessionDate;

        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)
            ->whereHas('group', function ($query) use ($serviceID) {
                $query->where('serviceID', $serviceID);})->first();

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

        return response()->json(['message' => 'Your reservation has been completed successfully', 'reservation' => $privateReservation], 201);
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

        $advancedUserID = $assignedService->advancedUserID;

        $conflictingReservation = PrivateReservation::whereHas('privateSession.session.service.assignedService', function ($query) use ($advancedUserID) {
            $query->where('advancedUserID', $advancedUserID);
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

            return response()->json(['message' => 'The new reservation time conflicts with an existing reservation.',
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

            return response()->json(['message' => 'Reservation delayed successfully.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while delaying the reservation.'], 500);
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
                    return response()->json(['message' => 'Reservation not found.'], 404);
                }

                $existingReservation->delete();

                FakeReservation::create([
                    'privateSessionID' => $privateSessionID,
                    'reservationStartTime' => $reservationStartTime,
                    'reservationEndTime' => $reservationEndTime,
                ]);

                DB::commit();

                return response()->json(['message' => 'Reservation deleted and slot is now available for booking.'], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'An error occurred while deleting the reservation.'], 500);
            }

        } else {
            return response()->json(['message' => 'Cannot delete reservation that has already started.'], 403);
        }
    }

    public function switch($receiverGroupReservationID)
    {
        $user = Auth::user();
        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();

        if (!$teamMember) {
            return response()->json(['message' => 'You are not part of any team.'], 403);
        }

        $senderReservation = PrivateReservation::where('groupID', $teamMember->groupID)->first();

        if (!$senderReservation) {
            return response()->json(['message' => 'No reservation found for your team.'], 404);
        }

        $receiverReservation = PrivateReservation::find($receiverGroupReservationID);

        if (!$receiverReservation) {
            return response()->json(['message' => 'No reservation found for the receiver team.'], 404);
        }

        $existingSwapRequest = SwapRequest::where('privateReservationID', $senderReservation->id)
            ->where('receiverGroupID', $receiverReservation->groupID)
            ->first();

        if ($existingSwapRequest) {
            return response()->json(['message' => 'Swap request already exists.'], 400);
        }

        $swapRequest = SwapRequest::create([
            'privateReservationID' => $senderReservation->id,
            'senderGroupID' => $teamMember->groupID,
            'receiverGroupID' => $receiverReservation->groupID,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Swap request sent successfully.', 'swapRequest' => $swapRequest], 201);
    }

    public function accept($swapRequestID)
    {
        $swapRequest = SwapRequest::find($swapRequestID);

        if (!$swapRequest) {
            return response()->json(['message' => 'Swap request not found.'], 404);
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

            $swapRequest->status = 'accepted';
            $swapRequest->save();
        });

        return response()->json(['message' => 'Swap request accepted successfully.'], 200);
    }

    public function decline($swapRequestID)
    {
        $swapRequest = SwapRequest::find($swapRequestID);

        if (!$swapRequest) {
            return response()->json(['message' => 'Swap request not found.'], 404);
        }

        if ($swapRequest->status !== 'pending') {
            return response()->json(['message' => 'Only pending swap requests can be rejected.'], 400);
        }

        $swapRequest->status = 'rejected';
        $swapRequest->save();

        return response()->json(['message' => 'Swap request rejected successfully.'], 200);
    }

    public function cancelSwapReservation($swapRequestID)
    {
        $user = Auth::user();
        $swapRequest = SwapRequest::find($swapRequestID);

        if (!$swapRequest) {
            return response()->json(['message' => 'Swap request not found.'], 404);
        }

        if ($swapRequest->status !== 'pending') {
            return response()->json(['message' => 'Only pending swap requests can be cancelled.'], 400);
        }

        $teamMember = TeamMember::where('normalUserID', $user->normalUser->id)->first();
        if ($swapRequest->senderGroupID !== $teamMember->groupID) {
            return response()->json(['message' => 'You are not authorized to cancel this swap request.'], 403);
        }

        $swapRequest->delete();

        return response()->json(['message' => 'Swap request cancelled successfully.'], 200);
    }

    public function markAsAttendance(PrivateReservation $privateReservation){
        $privateReservation->update(['privateReservationStatus'=>true]);
        return response()->json('attendance registered successfully',200);
    }

}
