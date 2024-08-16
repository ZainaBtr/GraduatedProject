<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\Response;

class StatisticController extends Controller
{
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function advancedUsersCount()
    {
        $data = $this->statisticService->advancedUsersCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function normalUsersCount()
    {
        $data = $this->statisticService->normalUsersCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function serviceManagersCount()
    {
        $data = $this->statisticService->serviceManagersCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalUsersCount()
    {
        $data = $this->statisticService->totalUsersCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function announcementsCount()
    {
        $data = $this->statisticService->announcementsCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openServicesCount()
    {
        $data = $this->statisticService->openServicesCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function closeServicesCount()
    {
        $data = $this->statisticService->closeServicesCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalServicesCount()
    {
        $data = $this->statisticService->totalServicesCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openSessionsCount()
    {
        $data = $this->statisticService->openSessionsCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openPrivateSessionsCount()
    {
        $data = $this->statisticService->openPrivateSessionsCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openPublicSessionsCount()
    {
        $data = $this->statisticService->openPublicSessionsCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalSessionsCount()
    {
        $data = $this->statisticService->totalSessionsCount();

        return response()->json($data, Response::HTTP_OK);
    }

    public function groupsCount()
    {
        $data = $this->statisticService->groupsCount();

        return response()->json($data, Response::HTTP_OK);
    }
}
