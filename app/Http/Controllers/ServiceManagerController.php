<?php

namespace App\Http\Controllers;
use App\Http\Requests\File\File1;
use App\Http\Requests\ServiceManager\ServiceManager1;
use App\Http\Requests\ServiceManager\ServiceManager2;
use App\Imports\AdvancedUserDataImport;
use App\Imports\NormalUserDataImport;
use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ServiceManagerController extends Controller
{

    public function showSystemManagerProfile()
    {
        $user = Auth::user();
        if(request()->is('api/*')){

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

        return view('');

    }

    public function completeAccount(ServiceManager2 $request)
    {
        $user = User::where('password',$request['password'])->first();

        if(!$user){
            return response()->json(['message' => 'Account Not Found']);
        }
        $user->update(['email' => $request['email']]);
        $this->sendEmail($request['email']);

    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('');

    }

    public function showAll()
    {
        $serviceManagers=ServiceManager::query()->get()->all();

        $result[]=array();

        foreach ($serviceManagers as $serviceManager){
            $result[] = User::query()->where('id',$serviceManager['userID'])->first();
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
