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
        $data = $this->statisticService->countAdvancedUsers();

        return response()->json($data, Response::HTTP_OK);
    }

    public function normalUsersCount()
    {
        $data = $this->statisticService->countNormalUsers();

        return response()->json($data, Response::HTTP_OK);
    }

    public function serviceManagersCount()
    {
        $data = $this->statisticService->countServiceManagers();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalUsersCount()
    {
        $data = $this->statisticService->countTotalUsers();

        return response()->json($data, Response::HTTP_OK);
    }

    public function announcementsCount()
    {
        $data = $this->statisticService->countAnnouncements();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openServicesCount()
    {
        $data = $this->statisticService->countOpenServices();

        return response()->json($data, Response::HTTP_OK);
    }

    public function closeServicesCount()
    {
        $data = $this->statisticService->countCloseServices();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalServicesCount()
    {
        $data = $this->statisticService->countTotalServices();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openSessionsCount()
    {
        $data = $this->statisticService->countOpenSessions();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openPrivateSessionsCount()
    {
        $data = $this->statisticService->countOpenPrivateSessions();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openPublicSessionsCount()
    {
        $data = $this->statisticService->countOpenPublicSessions();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalSessionsCount()
    {
        $data = $this->statisticService->countTotalSessions();

        return response()->json($data, Response::HTTP_OK);
    }

    public function groupsCount()
    {
        $data = $this->statisticService->countGroups();

        return response()->json($data, Response::HTTP_OK);
    }
}
