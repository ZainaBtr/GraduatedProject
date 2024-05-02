<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceYearAndSpecialization\ServiceYearAndSpecialization1;
use App\Models\ServiceYearAndSpecialization;
use Illuminate\Http\Response;

class ServiceYearAndSpecializationController extends Controller
{

    public function showAll()
    {
        $allRecords = ServiceYearAndSpecialization::all();

        return view('pages.YearAndSpecializationPageForServiceManager',compact('allRecords'));

        return response()->json($allRecords, Response::HTTP_OK);


    }

    public function add(ServiceYearAndSpecialization1 $request)
    {
        $recordStored = ServiceYearAndSpecialization::create($request->validated());

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function delete(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        $serviceYearAndSpecialization->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll()
    {
        ServiceYearAndSpecialization::query()->delete();

        return response()->json(['message' => 'all records deleted successfully']);
    }

}
