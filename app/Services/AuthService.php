<?php

namespace App\Services;

use App\Http\Requests\User\User1;
use App\Http\Requests\User\User2;
use App\Http\Requests\User\User3;
use App\Http\Requests\User\User4;
use App\Http\Requests\User\User5;
use App\Http\Requests\User\User6;
use App\Http\Requests\User\User7;
use App\Models\AdvancedUser;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function login(User1 $request)
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            throw new AuthenticationException();
        }
        $passwordIsValid = Hash::check($credentials['password'], $user->password);

        if (!$passwordIsValid && $user->password === $credentials['password']) {

            $passwordIsValid = true;
        }
        if (!$passwordIsValid) {

            throw new AuthenticationException();
        }
        Auth::login($user);

        $data = $this->controllerService->createToken($request->user());

        $serviceManager = $user->serviceManager;

        if ($request['deviceToken']) {

            $user->update(['deviceToken' => $request['deviceToken']]);
        }
        return compact('data','serviceManager');
    }

    public function changePassword(User2 $request)
    {
        $user = Auth::user();

        if (Hash::check($request['oldPassword'], $user['password'])){

            $user->update(['password' => Hash::make($request['newPassword'])]);

            return ['message' => 'Password has changed successfully'];
        }
        return ['Incorrect Password'];
    }

    public function forgetPassword(User3 $request)
    {
        $user = User::where('email', $request['email'])->first();

        if (!$user) {

            return ['message' => 'Account Not Found'];
        }
        $this->controllerService->sendEmail($request['email']);

        return ['message' => 'we send new code to your email'];
    }


    public function verification(User4 $request)
    {
        $email =$this->controllerService->checkToken($request);

        if ($email === false) {

            return ['success' => false, 'message' => "Invalid PIN"];
        }
        $user= User::query()->where('email', $email)->get()->first();

        DB::table('password_reset_tokens')->where('token', $request['token'])->delete();

        $data = $this->controllerService->createToken($user);

        return [$data,200,['success' => true, 'message' => 'your Email Is Verified']];
    }

    public function setNewPassword(User5 $request)
    {
        if ($request->is('api/*')) {

            $user = Auth::guard('api')->user();
        }
        else {
            $user = Auth::guard('web')->user();
        }
        if (!$user) {

            return ['message' => 'Unauthenticated'];
        }
        $user->update(['password' => Hash::make($request->input('password'))]);

        $normalUser=$user->normalUser;
        $advancedUser=$user->advancedUser;

        $normalUser?->update(['isAccountCompleted' => 1]);
        $advancedUser?->update(['isAccountCompleted' => 1]);

        return ['message' => 'Password Has Updated Successfully'];
    }

    public function setEmail(User6 $request)
    {
        if (request()->is('api/*')) {

            $user = Auth::guard('api')->user();
        }
        else {
            Auth::guard('web')->logout();

            session()->invalidate();

            session()->regenerateToken();

            $user = null;
        }
        if ($user === null) {

            $user = User::where('password', $request['password'])->first();

            if (!$user || $request['password']!=$user->password) {

                return ['message' => 'Account Not Found or Wrong Password'];
            }
        }
        $this->controllerService->sendEmail($request['email']);

        $user->update(['email' => $request['email'], 'deviceToken' => $request['deviceToken']]);

        return ['message' => 'We Sent 6 Digits Code To Your Email'];
    }

    public function updateEmail(User7 $request)
    {
        $user = Auth::user();

        if (!Hash::check($request['password'], $user->password)) {

            return ['message' => 'Wrong password'];
        }
        $user->update(['email' => $request['email']]);

        $this->controllerService->sendEmail($request['email']);

        return ['message' => 'We Sent 6 Digits Code To Your Email'];
    }

    public function deleteAccount(User $user)
    {
        $user->delete();

        return ['message' => 'Account Deleted Successfully'];
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

        return $user->createToken('MyApp')->accessToken;
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

        return $user->createToken('MyApp')->accessToken;
    }
}
