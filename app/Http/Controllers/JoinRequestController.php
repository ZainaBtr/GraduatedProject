<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\JoinRequest;
use App\Models\NormalUser;
use App\Models\Service;
use App\Services\JoinRequestService;

class JoinRequestController extends Controller
{
    protected $joinRequestService;

    public function __construct(JoinRequestService $joinRequestService)
    {
        $this->joinRequestService = $joinRequestService;
    }

    public function showSentJoinRequests()
    {
        return $this->joinRequestService->showSentJoinRequests();
    }

    public function showReceivedJoinRequests()
    {
        return $this->joinRequestService->showReceivedJoinRequests();
    }

    public function sendJoinRequest(Group $group)
    {
        return $this->joinRequestService->sendJoinRequest($group);
    }

    public function acceptJoinRequest(JoinRequest $joinRequest)
    {
        try {
            return $this->joinRequestService->acceptJoinRequest($joinRequest);
        }
        catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function declineJoinRequest(JoinRequest $joinRequest)
    {
        return $this->joinRequestService->declineJoinRequest($joinRequest);
    }

    public function cancelJoinRequest(JoinRequest $joinRequest)
    {
        return $this->joinRequestService->cancelJoinRequest($joinRequest);
    }

    public function showSentFromUserToGroup()
    {
        return $this->joinRequestService->showSentFromUserToGroup();
    }

    public function showSentFromGroupToUser()
    {
        return $this->joinRequestService->showSentFromGroupToUser();
    }

    public function showReceivedToGroupFromUser()
    {
        return $this->joinRequestService->showReceivedToGroupFromUser();
    }

    public function showReceivedToUserFromGroup()
    {
        return $this->joinRequestService->showReceivedToUserFromGroup();
    }

    public function create(Group $group)
    {
        return $this->joinRequestService->create($group);
    }

    public function ask(Service $service,NormalUser $normalUser)
    {
        return $this->joinRequestService->ask($service, $normalUser);
    }
}
