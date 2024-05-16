<?php

namespace App\Http\Controllers;
use App\Http\Requests\File\File1;
use App\Http\Requests\ServiceManager\ServiceManager1;
use App\Imports\AdvancedUserDataImport;
use App\Imports\NormalUserDataImport;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServiceManagerController extends Controller
{

    public function showSystemManagerProfile()
    {
        $user = Auth::user();
        if(request()->is('api/*')){
            return response()->json($user,200);
        }
        return view('');

    }

    public function createAccount(ServiceManager1 $request)
    {
         $user =User::query()->create([
             'fullName'=>$request['fullName'],
             'password'=>Str::random(12)
         ]);

         ServiceManager::query()->create([
                    'userID'=>$user['id'],
                      'position'=>$request['position']
                ]);

        if(request()->is('api/*')){
            return response()->json($user,200);
        }
        return view('');
    }

    public function showProfile()
    {
        $user = Auth::user();
        $userData = [
            'name' => $user->fullName,
            'email' => $user->email,
        ];
        $position = $user->serviceManager->position;

        $responseData = array_merge($userData, ['position' => $position]);

        if(request()->is('api/*')){
            return response()->json($responseData);
        }
        return view('');

    }

    public function showAll()
    {
        $serviceManagers = ServiceManager::with('user')->get();
        $responseData = [];

        foreach ($serviceManagers as $serviceManager) {
            $userData = [
                'name' => $serviceManager->user->fullName,
                'email' => $serviceManager->user->email,
                'position' => $serviceManager->position,
            ];
            $responseData[] = $userData;
        }

        if(request()->is('api/*')){
            return response()->json($responseData);
        }
        return view('');
    }

    public function addAdvancedUsersFile(File1 $request)
    {
        return $this->importUsersFile($request, AdvancedUserDataImport::class);
    }

    public function addNormalUsersFile(File1 $request)
    {
        return $this->importUsersFile($request, NormalUserDataImport::class);
    }

    public function deleteAccount(User $serviceManager)
    {
        $serviceManager->delete();

        if(request()->is('api/*')){
            return response()->json(['message' => ' Service Manager Deleted Successfully']);
        }
        return view('');

    }

}
