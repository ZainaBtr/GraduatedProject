<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\Group1;
use App\Models\NormalUser;
use App\Models\Service;
use App\Services\GroupService;

class GroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function showAll(Service $service)
    {
        return $this->groupService->showAll($service);
    }

    public function showMy()
    {
        return $this->groupService->showMy();
    }

    public function create(Service $service)
    {
        $response = $this->groupService->create($service);

        try{
            return response()->json($response);
        }
        catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchNormalUser(Group1 $request)
    {
        return $this->groupService->searchNormalUser($request);
    }

    public function getNormalUserDetails(NormalUser $normalUser)
    {
        return $this->groupService->getNormalUserDetails($normalUser);
    }
}
