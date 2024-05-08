<?php

namespace App\Http\Controllers;
use App\Http\Requests\File\File1;
use App\Http\Requests\ServiceManager\ServiceManager1;
use App\Http\Requests\ServiceManager\ServiceManager2;
use App\Imports\AdvancedUserDataImport;
use App\Imports\NormalUserDataImport;
use App\Models\ServiceManager;
use Maatwebsite\Excel\Facades\Excel;

class ServiceManagerController extends Controller
{

    public function showSystemManagerProfile()
    {
        //
    }

    public function createAccount(ServiceManager1 $request)
    {
        //
    }

    public function completeAccount(ServiceManager2 $request)
    {
        //
    }

    public function updateEmail(ServiceManager2 $request)
    {
        //
    }

    public function showProfile()
    {
        //
    }

    public function showAll()
    {
        //
    }

    public function addAdvancedUsersFile(File1 $request)
    {
        return $this->importUsersFile($request, AdvancedUserDataImport::class);
    }

    public function addNormalUsersFile(File1 $request)
    {
        return $this->importUsersFile($request, NormalUserDataImport::class);
    }

    public function deleteAccount(ServiceManager $serviceManager)
    {
        //
    }
}
