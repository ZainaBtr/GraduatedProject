<?php

namespace App\Http\Controllers;
use App\Http\Requests\AdvancedUser\AdvancedUser1;
use App\Http\Requests\AdvancedUser\AdvancedUser2;
use App\Models\AdvancedUser;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AdvancedUserController extends Controller
{

    public function showProfile()
    {
        $user = Auth::user();

        if(request()->is('api/*')){
            return response()->json($user);
        }
        return view('');

    }

    public function showAll()
    {
        $advancedUsers=AdvancedUser::query()->get()->all();
        $result[]=array();

        foreach ($advancedUsers as $advancedUser){
            $result[] = User::query()->where('id',$advancedUser['userID'])->first();
        }

        if(request()->is('api/*')){
            return response()->json($result,200);
        }

        return view('');
    }

    public function createAccount(AdvancedUser1 $request)
    {
        $user =User::query()->create([
            'fullName'=>$request['fullName'],
            'password'=>Str::random(12)
        ]);
        AdvancedUser::query()->create([
            'userID'=>$user['id']
        ]);

        if(request()->is('api/*')){
            return response()->json($user);

        }
        return view('');

    }

    /**
     * @throws AuthenticationException
     */

    public function setEmail(AdvancedUser2 $request)
    {
        $user = User::where('password',$request['password'])->first();
        if(!$user){
            return response()->json(['message' => 'Account Not Found']);
        }
        $user->update(['email' => $request['email']]);
        $this->sendEmail($request['email']);
    }

    public function updateEmail(AdvancedUser2 $request)
    {
        $user = Auth::user();
        $user->update(['email' => $request['email']]);
        $this->sendEmail($request['email']);
    }

    public function deleteAccount(User $advancedUser)
    {
        $advancedUser->delete();

        if(request()->is('api/*')){
            return response()->json(['message' => 'Account Deleted Successfully']);
        }
        return view('');
    }

    public function deleteAllAccounts()
    {
        $advancedUsers = AdvancedUser::query()->get()->all();

        foreach ($advancedUsers as $advancedUser){
            User::where('id', $advancedUser['userID'])->delete();
        }
        AdvancedUser::query()->delete();
        if(request()->is('api/*')){
            return response()->json(['message' => 'All Accounts have been Deleted Successfully']);
        }
        return view('');
    }

}
