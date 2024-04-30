<?php

namespace App\Http\Controllers;

use App\Http\Requests\Session\Session1;
use App\Http\Requests\Session\Session2;
use App\Http\Requests\Session\Session3;
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

    public function create(Session1 $request,Service $service)
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

    public function update(Session2 $request, Session $session)
    {
        //
    }

    public function search(Session3 $request)
    {
        //
    }

}
