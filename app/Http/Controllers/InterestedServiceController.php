<?php

namespace App\Http\Controllers;

use App\Models\InterestedService;
use App\Models\Service;
use App\Services\InterestedServiceService;
use Illuminate\Http\Response;

class InterestedServiceController extends Controller
{
    protected $interestedServiceService;

    public function __construct(InterestedServiceService $interestedServiceService)
    {
        $this->interestedServiceService = $interestedServiceService;
    }

    public function showAll()
    {
        $allRecords = $this->interestedServiceService->showAll();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showAllParent()
    {
        $allRecords = $this->interestedServiceService->showAllParent();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.FavoritePublicServicesPageForServiceManager',[
                'allRecords' => $allRecords
        ]);
    }

    public function showChild(Service $service)
    {
        $allRecords = $this->interestedServiceService->showChild($service);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.FavoritePrivateServicesPageForServiceManager', [
            'allRecords' => $allRecords,
            'parentService' => $service
        ]);
    }

    public function interestIn(Service $service)
    {
        $recordStored = $this->interestedServiceService->interestIn($service);

        if (request()->is('api/*')) {

            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function unInterestIn(InterestedService $interestedService)
    {
        $response = $this->interestedServiceService->unInterestIn($interestedService);

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
