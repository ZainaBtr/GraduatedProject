<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\User4;
use App\Mail\myEmail;
use App\Mail\VerifyEmail;
use App\Models\AdvancedUser;
use App\Models\ServiceManager;
use App\Http\Requests\User\User6;
use App\Http\Requests\User\User7;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
        $user = $request->user();
        $data= $this->createToken($user);
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
        if(request()->is('api/*')){
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

        DB::table('password_reset_tokens')
            ->where('token', $request['token'])
            ->delete();
        $data = $this->createToken($user);

        if(request()->is('api/*')){
            return  response()->json($data,200,['success' => true,
                'message' => 'We Sent 6 Digits Code To Your Email']);
        }
        return view('');
    }

    public function setNewPassword(User6 $request){
        $user=Auth::user();
        $user->update(['password' => Hash::make($request['password'])]);
        if(request()->is('api/*')){
            return response()->json(['message' => 'Password Has Updated Successfully'],200);
        }
        return view('');
    }

    public function setEmail(User7 $request)
    {
        $user = User::where('password', $request['password'])->first();
        if (!$user) {
            return response()->json(['message' => 'Account Not Found']);
        }
        $this->sendEmail($request['email']);
        $user->update(['email' => $request['email']]);
        if(request()->is('api/*')){
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
        $user->update(['email' => $request['email']]);
        $this->sendEmail($request['email']);
        if(request()->is('api/*')){
            return  response()->json(['message' => 'We Sent 6 Digits Code To Your Email'],200);
        }
        return view('');
    }
  
}
