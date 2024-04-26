<?php

namespace App\Http\Controllers;

use App\Models\AdvancedUser;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function showActiveTheoretical()
    {
        //
    }

    public function showActivePractical()
    {
        //
    }

    public function showAll(Service $service)
    {
        //
    }

    public function showAllRelatedToAdvancedUser(AdvancedUser $advancedUser)
    {
        //
    }

    public function showMy(Service $service)
    {
        //
    }

    public function create(Request $request,Service $service)
    {
        //
    }

    public function start(Session $session)
    {
        //
    }

    public function close(Session $session)
    {
        //
    }

    public function cancel(Session $session)
    {
        //
    }

    public function update(Request $request, Session $session)
    {
        //
    }

    public function search(Request $request)
    {
        //
    }

}
