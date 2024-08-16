<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitation\Invitation1;
use App\Models\Service;
use App\Services\InvitationService;
use App\Models\Invitation;

class InvitationController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }
    public function showSentInvitations()
    {
        return $this->invitationService->showSentInvitations();
    }

    public function showReceivedInvitations()
    {
        return $this->invitationService->showReceivedInvitations();
    }

    public function sendInvitation(Service $service, Invitation1 $request)
    {
        return $this->invitationService->sendInvitation($service, $request);
    }

    public function acceptInvitation(Invitation $invitation)
    {
        try {
            return $this->invitationService->acceptInvitation($invitation);
        }
        catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function declineInvitation(Invitation $invitation)
    {
        return $this->invitationService->declineInvitation($invitation);
    }

    public function cancelInvitation(Invitation $invitation)
    {
        return $this->invitationService->cancelInvitation($invitation);
    }
}
