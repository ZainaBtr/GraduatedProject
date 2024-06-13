<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\User4;
use App\Http\Requests\User\User5;
use App\Http\Requests\User\User6;
use App\Http\Requests\User\User7;
use App\Http\Requests\User\User8;
use App\Http\Requests\User\User7;
use App\Mail\myEmail;
use App\Http\Requests\User\User5;
use App\Http\Requests\User\User6;
use App\Models\AdvancedUser;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\User1;
use App\Http\Requests\User\User2;
use App\Http\Requests\User\User3;
use Illuminate\Auth\AuthenticationException;
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
        $data= $this->createToken($request->user());

        if(request()->is('api/*')){
            return response()->json($data,Response::HTTP_OK);
        }
        return view('Common.ChangePasswordPageForChangePassword');
    }

    public function changePassword(User2 $request)
    {
        $user = Auth::user();

        if (Hash::check($request['oldPassword'], $user['password'])){
            $user->update(['password' => Hash::make($request['newPassword'])]);

            if(request()->is('api/*')){
                return response()->json(['message' => 'Password has changed successfully'],200);
            }
            return view('');
        }
        return response()->json(['Incorrect Password'],405);
    }

    public function forgetPassword(User3 $request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'Account Not Found']);
        }
        $this->sendEmail($request['email']);

        if(request()->is('api/*')) {
            return response()->json(['message' => 'we send new code to your email'],200);
        }
        return view('');
    }

    public function verification(User4 $request)
    {
        $email =$this->checkToken($request);

        if ($email === false) {
            return new JsonResponse(['success' => false, 'message' => "Invalid PIN"], 400);
        }
        $user= User::query()->where('email', $email)->get()->first();

        DB::table('password_reset_tokens')->where('token', $request['token'])->delete();

        $data = $this->createToken($user);

        if(request()->is('api/*')){
            return  response()->json($data,200,['success' => true, 'message' => 'your Email Is Verified']);
        }
        return view('');
    }


    public function setNewPassword(User5 $request)
    {
        $user=Auth::user();

        $user->update(['password' => Hash::make($request['password'])]);

        if(request()->is('api/*')){
            return response()->json(['message' => 'Password Has Updated Successfully'],200);
        }
        return view('');
    }


    public function setEmail(User6 $request)
    {
        $user = Auth::guard('api')->user();

        if ($user === null) {
            $user = User::where('email', $request['email'])->first();

            if (!$user || !Hash::check($request['password'], $user->password)) {
                return response()->json(['message' => 'Account Not Found or Wrong Password'], 404);
            }

        $this->sendEmail($request['email']);

        $user->update(['email' => $request['email']]);


        if(request()->is('api/*')) {
            return  response()->json(['message' => 'We Sent 6 Digits Code To Your Email'],200);
        }

        return view('');
    }

    /**
     * @throws AuthenticationException
     */

    public function updateEmail(User7 $request)
    {
        $user = Auth::user();

        if (!Hash::check($request['password'], $user->password)) {
            return response()->json(['message' => 'Wrong password'], 400);
        }

        $user->update(['email' => $request['email']]);

        $this->sendEmail($request['email']);

        if(request()->is('api/*')) {
            return  response()->json(['message' => 'We Sent 6 Digits Code To Your Email'],200);
        }
        return view('');
    }

    public function deleteAccount(User $user)
    {
        $user->delete();

        if(request()->is('api/*')){
            return response()->json(['message' => 'Account Deleted Successfully']);
        }
        return view('');
    }

    public function register(Request $request)
    {
        $user = User::create([
            'fullName' => $request['fullName'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])

        ]);

        ServiceManager::create([
            'userID' => $user->id,
            'position' => $request['position']
        ]);

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json($token, \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    public function advancedUserRegister(Request $request)
    {
        $user = User::create([
            'fullName' => $request['fullName'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])

        ]);

        AdvancedUser::create([
            'userID' => $user->id
        ]);

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json($token, \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

}
