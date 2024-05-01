<?php

namespace App\Http\Controllers;

use App\Http\Requests\NormalUser\NormalUser1;
use App\Http\Requests\NormalUser\NormalUser2;
use App\Http\Requests\NormalUser\NormalUser3;
use App\Http\Requests\NormalUser\NormalUser4;
use App\Http\Requests\NormalUser\NormalUser5;
use App\Models\NormalUser;
use App\Models\User;
use Illuminate\Http\Request;

class NormalUserController extends Controller
{

    public function showProfile()
    {
        //
    }

    public function showAll()
    {
        //
    }

    public function completeAccount1(NormalUser1 $request)
    {
        //
    }

   public function completeAccount2(NormalUser2 $request)
    {
        //
    }

   public function completeAccount3(NormalUser3 $request)
    {
        //
    }

   public function completeAccount4(NormalUser4 $request)
    {
        //
    }

    public function updateEmail(NormalUser5 $request)
    {
        //
    }

    public function deleteAllAccounts( )
    {
        //
    }

}
