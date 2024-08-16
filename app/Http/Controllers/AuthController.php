<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\User4;
use App\Http\Requests\User\User6;
use App\Http\Requests\User\User7;
use App\Mail\myEmail;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\User\User1;
use App\Http\Requests\User\User2;
use App\Http\Requests\User\User3;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(User1 $request)
    {
        $response = $this->authService->login($request);

        if (request()->is('api/*')) {

            return response()->json($response['data'], Response::HTTP_OK);
        }
        if($response['serviceManager']) {

            return redirect()->action([NormalUserController::class, 'showAll']);
        }
        return redirect()->action([ServiceManagerController::class, 'showAll']);
    }

    public function changePassword(User2 $request)
    {
        $response = $this->authService->changePassword($request);

        if(request()->is('api/*')){

            return response()->json($response);
        }
        return view('');
    }

    public function forgetPassword(User3 $request)
    {
        $response = $this->authService->forgetPassword($request);

        if(request()->is('api/*')) {

            return response()->json($response);
        }
        return view('Common.VerificationCodePage');
    }

    public function verification(User4 $request)
    {
        $response = $this->authService->verification($request);

        if(request()->is('api/*')){

            return  response()->json($response);
        }
        return redirect()->action([NormalUserController::class, 'showAll']);
    }

    public function setNewPassword(Request $request)
    {
        $response = $this->authService->setNewPassword($request);

        if ($request->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->action([NormalUserController::class, 'showAll']);
    }

    public function setEmail(User6 $request)
    {
        $response = $this->authService->setEmail($request);

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return view('Common.VerificationCodePage');
    }

    public function updateEmail(User7 $request)
    {
        $response = $this->authService->updateEmail($request);

         if(request()->is('api/*')){

             return  response()->json($response);
         }
            return view('Common.VerificationCodePage');
    }

    public function deleteAccount(User $user)
    {
        $response = $this->authService->deleteAccount($user);

        if(request()->is('api/*')){

            return response()->json($response);
        }
        return redirect()->back();
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function advancedUserRegister(Request $request)
    {
        return $this->authService->advancedUserRegister($request);
    }
}
