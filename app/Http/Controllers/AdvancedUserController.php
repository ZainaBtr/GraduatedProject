<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvancedUser\AdvancedUser2;
use App\Models\AdvancedUser;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

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

    public function createAccount(Request $request)
    {
        //
    }

    /**
     * @throws AuthenticationException
     */


    public function completeAccount(AdvancedUser2 $request)
    {
        $user = User::where('password',$request['password'])->first();

        if(!$user){
            return response()->json(['message' => 'Account Not Found']);
        }
        $user->update(['email' => $request['email']]);
        return response()->json(['message' => 'we sent 6 digit code to this email']);
    }



    public function updateEmail(Request $request)
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
