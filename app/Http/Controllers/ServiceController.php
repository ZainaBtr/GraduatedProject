<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceMananger;
use Illuminate\Http\Request;

class ServiceController extends Controller
{


    public function showAllServices()
    {
        //
    }

    public function showServicesByYearAndSpecializationInGeneral()
    {
        //
    }

    public function showActivityServicesInGeneral()
    {
        //
    }

    public function showprojectIntreviewServicesInGeneral()
    {
        //
    }

    public function showDoctorIntreviewServicesInGeneral()
    {
        //
    }

    public function showExamServicesInGeneral()
    {
        //
    }

    public function showMyServices()
    {
        //
    }

    public function showAdvancedUsersOfService(Service $service)
    {
        //
    }

    public function addService(Request $request, ServiceMananger $serviceMananger, Service $parentService )
    {
        //
    }

    public function updateService(Request $request, Service $service , ServiceMananger $serviceMananger , Service $parentService)
    {
        //
    }

    public function deleteService(Service $service)
    {
        //
    }

    public function deleteAllService()
    {
        //
    }

    public function serviceSearch(Request $request)
    {
        //
    }

    public function serviceFilterByServiceYear(Request $request)
    {
        //
    }

    public function serviceFilterByServiceSpecialization(Request $request)
    {
        //
    }

    public function serviceFilterByServiceType(Request $request)
    {
        //
    }

}
