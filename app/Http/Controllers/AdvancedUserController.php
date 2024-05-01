<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvancedUser\AdvancedUser1;
use App\Http\Requests\AdvancedUser\AdvancedUser2;
use App\Models\AdvancedUser;
use App\Models\User;

class AdvancedUserController extends Controller
{

    public function showProfile()
    {
        //
    }

    public function showAll()
    {
        $allRecords = User::all();

        return view('pages.AdvancedUsersTablePageForServiceManager',compact('allRecords'));
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
