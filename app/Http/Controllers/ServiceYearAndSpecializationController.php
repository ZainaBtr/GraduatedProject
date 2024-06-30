<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServiceYearAndSpecialization\ServiceYearAndSpecialization1;
use App\Models\ServiceManager;
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
        return redirect()->back();
        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function delete(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        $serviceYearAndSpecialization->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            ServiceYearAndSpecialization::query()->delete();

            return response()->json(['message' => 'all records deleted successfully']);
        }
        return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
    }

}
