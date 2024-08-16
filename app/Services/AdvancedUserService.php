<?php

namespace App\Services;

use App\Http\Requests\AdvancedUser\AdvancedUser1;
use App\Models\AdvancedUser;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdvancedUserService
{
    public function showProfile()
    {
        return Auth::user();
    }

    public function showAll()
    {
        $users = User::whereHas('advancedUser')->get();

        $usersData = [];

        foreach ($users as $user) {

            if ($user->advancedUser->isAccountCompleted == 0) {

                $usersData[] = [
                    'id' => $user->advancedUser->id,
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'password' => $user->password,
                    'isAccountCompleted'=>$user->advancedUser->isAccountCompleted
                ];
            }
            else {
                $usersData[] = [
                    'id' => $user->advancedUser->id,
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'isAccountCompleted'=>$user->advancedUser->isAccountCompleted
                ];
            }
        }
        return $usersData;
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
        return $user;
    }

    // complete account = set email in AuthController

    public function deleteAllAccounts()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            User::whereHas('advancedUser')->delete();

            return ['message' => 'All Accounts have been Deleted Successfully'];
        }
        return ['message' => 'you dont have the permission to delete all records in this table'];
    }
}
