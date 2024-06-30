<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\File1;
use App\Http\Requests\ServiceManager\ServiceManager1;
use App\Imports\AdvancedUserDataImport;
use App\Imports\NormalUserDataImport;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServiceManagerController extends Controller
{

    public function showSystemManagerProfile()
    {
        $user = Auth::user();

        if(request()->is('api/*')){
            return response()->json($user,200);
        }
        return view('page.MyAccountPageForSystemManager',compact('user'));
        
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
        return redirect()->back();
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

        if(request()->is('api/*')){
            return response()->json($responseData);
        }
        return view('pages.MyAccountPageForServiceManager',compact('user','position'));
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
        if(request()->is('api/*')) {
            return response()->json($usersData);
        }
        return view('page.ServiceManagersTablePageForSystemManager', [
            'usersData' => $usersData,
            'serviceManagers' => $serviceManagers,]);

            
     
        
    }

    public function addAdvancedUsersFile(File1 $request)
    {
        return $this->importUsersFile($request, AdvancedUserDataImport::class);
        return redirect()->back();
        
        

    }

    public function addNormalUsersFile(File1 $request)
    {
        return $this->importUsersFile($request, NormalUserDataImport::class);
        return redirect()->back();
    }

}
