<?php

namespace App\Services;

use App\Http\Requests\File\File1;
use App\Http\Requests\ServiceManager\ServiceManager1;
use App\Imports\AdvancedUserDataImport;
use App\Imports\NormalUserDataImport;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServiceManagerService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showSystemManagerProfile()
    {
        return Auth::user();
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

        return $user;
    }

    public function showProfile()
    {
        $user = Auth::user();

        $userData = [
            'fullName' => $user->fullName,
            'email' => $user->email,
        ];
        $position = $user->serviceManager->position;

        $responseData = array_merge($userData, ['position' => $position]);

        return compact('responseData','user', 'position');

//        return [
//            'responseData' => $responseData,
//            'user' => $user,
//            'position' => $position,
//        ];
    }

    public function showAll()
    {
        $serviceManagers = ServiceManager::with('user')->get();

        $usersData = [];

        foreach ($serviceManagers as $serviceManager) {

            $info = Hash::info($serviceManager->user->password);

            if ($info['algoName'] == 'unknown')
            {
                $usersData[] = [
                    'id' => $serviceManager->user->id,
                    'fullName' => $serviceManager->user->fullName,
                    'email' => $serviceManager->user->email,
                    'password' => $serviceManager->user->password,
                    'position' => $serviceManager->position
                ];
            }
            else {
                $usersData[] = [
                    'id' => $serviceManager->user->id,
                    'fullName' => $serviceManager->user->fullName,
                    'email' => $serviceManager->user->email,
                    'position' => $serviceManager->position
                ];
            }
        }
        return compact('usersData','serviceManagers');
    }

    public function addAdvancedUsersFile(File1 $request)
    {
        return $this->controllerService->importUsersFile($request, AdvancedUserDataImport::class);
    }

    public function addNormalUsersFile(File1 $request)
    {
        return $this->controllerService->importUsersFile($request, NormalUserDataImport::class);
    }
}
