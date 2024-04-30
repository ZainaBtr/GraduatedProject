<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicSession\PublicSession1;
use App\Http\Requests\PublicSession\PublicSession2;
use App\Models\PublicSession;
use App\Models\Session;
use Illuminate\Http\Request;

class PublicSessionController extends Controller
{

    public function showActivities()
    {
        //
    }

    public function showExams()
    {
        //
    }

    public function showMyActivities()
    {
        //
    }

    public function showMyExams()
    {
        //
    }

    public function create(PublicSession1 $request, Session $session)
    {
        //
    }

    public function update(PublicSession2 $request, PublicSession $publicSession)
    {
        //
    }

}
