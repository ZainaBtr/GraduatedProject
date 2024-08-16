<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\Service1;
use App\Http\Requests\Service\Service2;
use App\Http\Requests\Service\Service3;
use App\Http\Requests\Service\Service4;
use App\Models\Service;
use App\Models\ServiceYearAndSpecialization;
use App\Services\ServiceService;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function showServiceNameForDynamicDropDown()
    {
        return $this->serviceService->showServiceNameForDynamicDropDown();
    }

    public function showServiceYearAndSpecForDynamicDropDown()
    {
        return $this->serviceService->showServiceYearAndSpecForDynamicDropDown();
    }

    public function showAllParent()
    {
        $allRecords = $this->serviceService->showAllParent();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.PublicServicesInHomePageForServiceManager',compact('allRecords'));
    }

    public function showChild(Service $service)
    {
        $allRecords = $this->serviceService->showChild($service);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.PrivateServicesInHomePageForServiceManager', [
            'allRecords' => $allRecords,
            'parentService' => $service
        ]);
    }

    public function showMyAllParentFromServiceManager()
    {
        $allRecords = $this->serviceService->showMyAllParentFromServiceManager();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.MyPublicServicesInHomePageForServiceManager',compact('allRecords'));
    }

    public function showMyChildFromServiceManager(Service $service)
    {
        $allRecords = $this->serviceService->showMyChildFromServiceManager($service);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.MyPrivateServicesInHomePageForServiceManager', [
            'allRecords' => $allRecords,
            'parentService' => $service
        ]);
    }

    public function showByYearAndSpecialization(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        return $this->serviceService->showByYearAndSpecialization($serviceYearAndSpecialization);
    }

    public function showByType($type)
    {
        return $this->serviceService->showByType($type);
    }

    public function showMyFromAdvancedUser()
    {
         return $this->serviceService->showMyFromAdvancedUser();
    }

    public function showAdvancedUsersOfService(Service $service)
    {
        return $this->serviceService->showAdvancedUsersOfService($service);
    }

    public function add(Service1 $request, ?Service $parentService = null)
    {
        $recordStored =  $this->serviceService->add($request, $parentService);

        if (request()->is('api/*')) {

            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function update(Service2 $request, Service $service)
    {
        $service =  $this->serviceService->update($request, $service);

        if (request()->is('api/*')) {

            return response()->json($service, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function delete(Service $service)
    {
        $response =  $this->serviceService->delete($service);

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }

    public function deleteAll()
    {
        $response =  $this->serviceService->deleteAll();

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }

    public function searchForServiceManager(Service3 $request)
    {
        $allRecords =  $this->serviceService->searchForServiceManager($request);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.PublicServicesInHomePageForServiceManager', compact('allRecords'));
    }

    public function searchForAdvancedUser(Service3 $request)
    {
        return $this->serviceService->searchForAdvancedUser($request);
    }

    public function filterByType(Service4 $request)
    {
        $allRecords = $this->serviceService->filterByType($request);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('',compact(''));
    }
}
