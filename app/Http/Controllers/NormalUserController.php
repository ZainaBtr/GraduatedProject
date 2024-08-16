<?php

namespace App\Http\Controllers;

use App\Http\Requests\NormalUser\NormalUser1;
use App\Http\Requests\NormalUser\NormalUser2;
use App\Http\Requests\NormalUser\NormalUser4;
use App\Services\NormalUserService;

class NormalUserController extends Controller
{
    protected $normalUserService;

    public function __construct(NormalUserService $normalUserService)
    {
        $this->normalUserService = $normalUserService;
    }

    public function showProfile()
    {
        return $this->normalUserService->showProfile();
    }

    public function showAll()
    {
        $usersData = $this->normalUserService->showAll();

        if (request()->is('api/*')) {

            return response()->json($usersData, 200);
        }
        return view('pages.NormalUsersTablePageForServiceManager',compact('usersData'));
    }

    public function completeAccount1(NormalUser1 $request)
    {
        return $this->normalUserService->completeAccount1($request);
    }

   public function completeAccount2(NormalUser2 $request)
    {
        return $this->normalUserService->completeAccount2($request);
    }

    // complete account 3 = update email in  AuthController;

   public function completeAccount4(NormalUser4 $request)
    {
        return $this->normalUserService->completeAccount4($request);
    }

    public function deleteAllAccounts( )
    {
        $response = $this->normalUserService->deleteAllAccounts();

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
