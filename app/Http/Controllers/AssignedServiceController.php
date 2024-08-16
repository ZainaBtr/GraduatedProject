<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignedService\AssignedService1;
use App\Models\User;
use App\Models\AssignedService;
use App\Services\AssignedServiceService;
use Illuminate\Http\Response;

class AssignedServiceController extends Controller
{
    protected $assignedServiceService;

    public function __construct(AssignedServiceService $assignedServiceService)
    {
        $this->assignedServiceService = $assignedServiceService;
    }

    public function showAll(User $user)
    {
        $allRecords = $this->assignedServiceService->showAll($user);

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.AdvancedUserServicePageForServiceManager', [
            'allRecords' => $allRecords,
            'user' => $user
        ]);
    }

    public function assign(AssignedService1 $request, User $user)
    {
        $recordStored = $this->assignedServiceService->assign($request, $user);

        if (request()->is('api/*')) {

            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function delete(AssignedService $assignedService)
    {
        $response = $this->assignedServiceService->delete($assignedService);

        if (request()->is('api/*')) {

            return response()->json($response, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function deleteAll(User $user)
    {
        $response = $this->assignedServiceService->deleteAll($user);

        if (request()->is('api/*')) {

            return response()->json($response, Response::HTTP_OK);
        }
        return redirect()->back();
    }
}
