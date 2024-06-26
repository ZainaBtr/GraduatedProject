<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\JoinRequest;
use App\Models\NormalUser;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    public function showSentInvitations()
    {
        $user = Auth::user();

        $normalUser = $user->normalUser;

        $groupIDs = TeamMember::where('normalUserID', $normalUser->id)->pluck('groupID');

        $invitations = Invitation::whereIn('groupID', $groupIDs)
            ->with(['normalUser.user', 'group.service'])
            ->get();

        return response()->json($invitations->map(function($invitation) {
            return [
                'invitationID' => $invitation->id,
                'receiverName' => $invitation->normalUser->user->fullName,
                'serviceName' => $invitation->group->service->serviceName,
                'parentServiceName' => $invitation->group->service->parentService ? $invitation->group->service->parentService->serviceName : null,
                'requestDate' => $invitation->requestDate,
                'status' => $invitation->status,
            ];
        }));
    }

    public function showReceivedInvitations()
    {
        $user = Auth::user();
        $normalUserID=$user->normalUser->id;
        $invitations = Invitation::where('normalUserID', $normalUserID)
            ->with(['group.teamMembers.normalUser.user', 'group.service'])
            ->get();

        return response()->json($invitations->map(function($invitation) {
            return [
                'invitationID' => $invitation->id,
                'groupMembers' => $invitation->group->teamMembers->map(function($member) {
                    return $member->normalUser->user->fullName;
                }),
                'serviceName' => $invitation->group->service->serviceName,
                'parentServiceName' => $invitation->group->service->parentService ? $invitation->group->service->parentService->serviceName : null,
                'requestDate' => $invitation->requestDate,
                'status' => $invitation->status,
            ];
        }));
    }

    public function sendInvitation(Service $service, NormalUser $normalUser)
    {
        $user = Auth::user();
        $normalUserID = $user->normalUser->id;

        $group = Group::where('serviceID', $service->id)
            ->whereHas('teamMembers', function ($query) use ($normalUserID) {
                $query->where('normalUserID', $normalUserID);
            })->first();

        if (!$group) {
            return response()->json(['message' => 'Group not found or you are not a member of the group'], 404);
        }

        if ($group->teamMembers()->count() >= $service->maximumNumberOfGroupMembers) {
            return response()->json(['message' => 'Group has reached the maximum number of members'], 400);
        }

        if ($group->teamMembers->contains('normalUserID', $normalUser->id)) {
            return response()->json(['message' => 'The user is already a member of the group'], 400);
        }

        $existingInvitation = Invitation::where('normalUserID', $normalUser->id)->where('groupID', $group->id)->first();

        if ($existingInvitation) {
            return response()->json(['message' => 'An invitation has already been sent'], 400);
        }

        $invitation = Invitation::create([
            'groupID' => $group->id,
            'normalUserID' => $normalUser->id,
            'requestDate'=>Carbon::today(),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Invitation Sent Successfully', 'invitation' => $invitation], 201);
    }

    public function acceptInvitation(Invitation $invitation)
    {
        DB::beginTransaction();
        try {
            if ($invitation->status !== 'pending') {
                return response()->json(['message' => 'This invitation cannot be updated'], 400);
            }
            $group = Group::findOrFail($invitation->groupID);
            $service = $group->service;

            if ($group->teamMembers()->count() >= $service->maximumNumberOfGroupMembers) {
                return response()->json(['message' => 'Group has reached the maximum number of members'], 400);
            }

            TeamMember::create([
                'normalUserID' => $invitation->normalUserID,
                'groupID' => $invitation->groupID,
            ]);

            Invitation::where('normalUserID', $invitation->normalUserID)
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('serviceID', $group->serviceID);
                })->update(['status' => 'cancelled']);

            $invitation->update(['status' => 'accepted']);

            JoinRequest::where('senderID', $invitation->normalUserID)
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('serviceID', $group->serviceID);
                })->update(['joiningRequestStatus' => 'cancelled']);

            DB::commit();

            return response()->json(['message' => 'Invitation accepted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function declineInvitation(Invitation $invitation)
    {
        if ($invitation->status !== 'pending') {
            return response()->json(['message' => 'This invitation cannot be updated'], 400);
        }
        $invitation->update(['status' => 'declined']);
        return response()->json(['message' => 'Invitation declined successfully'], 200);
    }

    public function cancelInvitation(Invitation $invitation)
    {
        $invitation->delete();
        return response()->json(['message' => 'Invitation canceled successfully'], 200);
    }

}
