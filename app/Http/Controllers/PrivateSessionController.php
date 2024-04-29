<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivateSession\PrivateSession1;
use App\Http\Requests\PrivateSession\PrivateSession2;
use App\Models\PrivateSession;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Http\Request;

class PrivateSessionController extends Controller
{

    public function showProjectsInterviews()
    {
        //
    }

    public function showAdvancedUsersInterviews()
    {
        //
    }

    public function showMyProjectsInterviews()
    {
        //
    }

    public function showMyAdvancedUsersInterviews()
    {
        //
    }

    public function create(PrivateSession1 $request, Session $session)
    {
        //
    }

    public function update(PrivateSession2 $request, PrivateSession $privateSession)
    {
        //
    }

}
