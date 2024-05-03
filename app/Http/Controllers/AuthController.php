<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\User4;
use App\Mail\myEmail;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\User1;
use App\Http\Requests\User\User2;
use App\Http\Requests\User\User3;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{

    /**
     * @throws AuthenticationException
     */

    public function login(User1 $request)
    {
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials)){
            throw new AuthenticationException();
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);

    }

    public function changePassword(User2 $request)
    {
        $user = Auth::user();
        if ($request['oldPassword'] = $user->getAuthPassword()){
            $user->update(['password' => Hash::make($request['newPassword'])]);
            return response()->json(['message' => 'Password has changed successfully']);
        }
        return response()->json(['message' => 'Password is incorrect']);
    }

    public function forgetPassword(User3 $request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'Account Not Found']);
        }
        $pin = rand(100000, 999999);
        DB::table('password_reset_tokens')->insert(['email' => $user['email'], 'token' => $pin ]);
        Mail::to($user['email'])->send(new VerifyEmail($pin));
    }

    public function verification(User4 $request)
    {
        $validated = $request->validated();
            if ($validated->fails()) {
                return response()->json($validated->errors()->all(),Response::HTTP_UNPROCESSABLE_ENTITY );
            }

        $select = DB::table('password_resets')
                ->where('token', $request['token']);

            if ($select->get()->isEmpty()) {
                return new JsonResponse(['success' => false, 'message' => "Invalid PIN"], 400);
            }

            DB::table('password_resets')
                ->where('token', $request['token'])
                ->delete();

            return new JsonResponse(['success' => true, 'message' => "Email is verified"], 200);

    }

    public function sendEmail(User3 $user3)
    {
        $verify2 = DB::table('password_reset_tokens')->where([['email', $user3['email']]]);

        if ($verify2->exists()) {
            $verify2->delete();
            }
        $pin = rand(100000, 999999);

        DB::table('password_reset_tokens')->insert(['email' => $user3['email'], 'token' => $pin ]);

        Mail::to($user3['email'])->send(new VerifyEmail($pin));

        return new JsonResponse(
            ['success' => true,
             'message' => 'Please check your email for a 6-digit pin to verify your email'], 200
        );
    }

}
