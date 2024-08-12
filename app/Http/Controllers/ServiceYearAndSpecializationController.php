<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServiceYearAndSpecialization\ServiceYearAndSpecialization1;
use App\Models\ServiceYearAndSpecialization;
use App\Services\ServiceYearAndSpecializationService;
use Illuminate\Http\Response;

class ServiceYearAndSpecializationController extends Controller
{
    protected $serviceYearAndSpecializationService;

    public function __construct(ServiceYearAndSpecializationService $serviceYearAndSpecializationService)
    {
        $this->serviceYearAndSpecializationService = $serviceYearAndSpecializationService;
    }

    public function showAll()
    {
        $allRecords = $this->serviceYearAndSpecializationService->getAllRecords();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.YearAndSpecializationPageForServiceManager',compact('allRecords'));
    }

    public function add(ServiceYearAndSpecialization1 $request)
    {
        $recordStored = $this->serviceYearAndSpecializationService->addRecord($request->validated());

        if (request()->is('api/*')) {

            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function delete(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        $response = $this->serviceYearAndSpecializationService->deleteRecord($serviceYearAndSpecialization);

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }

    public function deleteAll()
    {
        $response = $this->serviceYearAndSpecializationService->deleteAllRecords();

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
