<?php

namespace App\Http\Controllers;
use App\Http\Requests\AdvancedUser\AdvancedUser1;
use App\Models\AdvancedUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $users = User::whereHas('advancedUser')->get();

        $advancedUser = [];

        foreach ($users as $user) {
            $accountStatus = $user->advancedUser->isAccountCompleted;

            $advancedUser[] = [
                'full_name' => $user->fullName,
                'email' => $user->email,
                'accountStatus'=>$accountStatus
            ];
        }

        if(request()->is('api/*')) {
                return response()->json($advancedUser, 200);
            }

        return view('');
    }

    // complete account = set email in auth controller

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
        User::whereHas('advancedUser')->delete();

        AdvancedUser::query()->delete();
        if(request()->is('api/*')){
            return response()->json(['message' => 'All Accounts have been Deleted Successfully']);
        }
        return view('');
    }
}
