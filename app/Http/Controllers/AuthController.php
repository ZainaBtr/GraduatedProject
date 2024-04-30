<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\User1;
use App\Http\Requests\User\User2;
use App\Http\Requests\User\User3;
use App\Http\Requests\User\User4;
use App\Http\Requests\User\User5;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(User1 $request)
    {
        //
    }

    public function changePassword(User2 $request)
    {
        //
    }

    public function forgetPassword(User3 $request)
    {
        //
    }

    public function verification(User4 $request)
    {
        //
    }

    public function sendEmail(User5 $request)
    {
        //
    }

}
