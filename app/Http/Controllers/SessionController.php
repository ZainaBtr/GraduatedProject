<?php

namespace App\Http\Controllers;

use App\Models\AdvancedUser;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function SshowActiveTheoreticalSessions()
    {
        //
    }

    public function SshowActivePracticalSessions()
    {
        //
    }

    public function SDshowAllSessions(Service $service)
    {
        //
    }

    public function SDshowAllSessionsRelatedToAdvancedUser(AdvancedUser $advancedUser)
    {
        //
    }

    public function DshowMySessions(Service $service)
    {
        //
    }

    public function createSession(Request $request,Service $service)
    {
        //
    }

    public function startSession(Session $session)
    {
        //
    }

    public function closeSession(Session $session)
    {
        //
    }

    public function cancelSession(Session $session)
    {
        //
    }

    public function updateSession(Request $request, Session $session)
    {
        //
    }

    public function sessionSearch(Request $request)
    {
        //
    }
}
