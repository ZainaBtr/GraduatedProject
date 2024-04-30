<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvancedUser\AdvancedUser1;
use App\Http\Requests\AdvancedUser\AdvancedUser2;
use App\Models\AdvancedUser;
use Illuminate\Http\Request;

class AdvancedUserController extends Controller
{

    public function showProfile()
    {
        //
    }

    public function showAll()
    {
        //
    }

    public function createAccount(AdvancedUser1 $request)
    {
        //
    }

    public function completeAccount(AdvancedUser2 $request)
    {
        //
    }

    public function updateEmail(AdvancedUser2 $request)
    {
        //
    }

    public function deleteAccount(AdvancedUser $advancedUser)
    {
        //
    }

    public function deleteAllAccounts()
    {
        //
    }

}
