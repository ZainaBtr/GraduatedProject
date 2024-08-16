<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvancedUser\AdvancedUser1;
use App\Services\AdvancedUserService;

class AdvancedUserController extends Controller
{
    protected $advancedUserService;

    public function __construct(AdvancedUserService $advancedUserService)
    {
        $this->advancedUserService = $advancedUserService;
    }

    public function showProfile()
    {
        return $this->advancedUserService->showProfile();
    }

    public function showAll()
    {
        $usersData = $this->advancedUserService->showAll();

        if(request()->is('api/*')) {

            return response()->json($usersData, 200);
        }
        return view('pages.AdvancedUsersTablePageForServiceManager',compact('usersData'));
    }

    public function createAccount(AdvancedUser1 $request)
    {
        $user = $this->advancedUserService->createAccount($request);

        if(request()->is('api/*')) {

            return response()->json($user);
        }
        return redirect()->back();
    }

    // complete account = set email in AuthController

    public function deleteAllAccounts()
    {
        $response = $this->advancedUserService->deleteAllAccounts();

        if(request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
