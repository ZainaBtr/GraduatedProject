<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\File1;
use App\Http\Requests\ServiceManager\ServiceManager1;
use App\Services\ServiceManagerService;

class ServiceManagerController extends Controller
{
    protected $serviceManagerService;

    public function __construct(ServiceManagerService $serviceManagerService)
    {
        $this->serviceManagerService = $serviceManagerService;
    }

    public function showSystemManagerProfile()
    {
        $user = $this->serviceManagerService->showSystemManagerProfile();

        if(request()->is('api/*')){

            return response()->json($user,200);
        }
        return view('page.MyAccountPageForSystemManager',compact('user'));
    }

    public function createAccount(ServiceManager1 $request)
    {
        $user = $this->serviceManagerService->createAccount($request);

        if(request()->is('api/*')){

            return response()->json($user,200);
        }
        return redirect()->back();
    }

    public function showProfile()
    {
        $response = $this->serviceManagerService->showProfile();

        if(request()->is('api/*')){

            return response()->json($response['responseData']);
        }
        return view('pages.MyAccountPageForServiceManager',compact($response['user'],$response['position']));
    }

    public function showAll()
    {
        $response = $this->serviceManagerService->showAll();

        if(request()->is('api/*')) {

            return response()->json($response['$usersData']);
        }
        return view('page.ServiceManagersTablePageForSystemManager', [
            'usersData' => $response['usersData'],
            'serviceManagers' => $response['serviceManagers'],
        ]);
    }

    public function addAdvancedUsersFile(File1 $request)
    {
        return $this->serviceManagerService->addAdvancedUsersFile($request);
    }

    public function addNormalUsersFile(File1 $request)
    {
        return $this->serviceManagerService->addNormalUsersFile($request);
    }
}
