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

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.YearAndSpecializationPageForServiceManager',compact('allRecords'));
    }

    public function add(ServiceYearAndSpecialization1 $request)
    {
        $recordStored = ServiceYearAndSpecialization::create($request->validated());

        if (request()->is('api/*')) {
            return response()->json($recordStored, Response::HTTP_OK);
        }
        return view('');
    }

    public function delete(ServiceYearAndSpecialization $serviceYearAndSpecialization)
    {
        $serviceYearAndSpecialization->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'this record deleted successfully']);
        }
        return view('');
    }

    public function deleteAll()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            ServiceYearAndSpecialization::query()->delete();

            if (request()->is('api/*')) {
                return response()->json(['message' => 'all records deleted successfully']);
            }
            return view('');
        }
        if (request()->is('api/*')) {
            return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
        }
        return view('');
    }

}
