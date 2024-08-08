<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Group;
use App\Models\PrivateSession;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Response;

class StatisticController extends Controller
{

    public function advancedUsersCount()
    {
        $data = User::whereHas('advancedUser')->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function normalUsersCount()
    {
        $data = User::whereHas('normalUser')->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function serviceManagersCount()
    {
        $data = User::whereHas('serviceManager')->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalUsersCount()
    {
        $data = User::all()->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function announcementsCount()
    {
        $data = Announcement::all()->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openServicesCount()
    {
        $data = Service::where('status', 1)->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function closeServicesCount()
    {
        $data = Service::where('status', 0)->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalServicesCount()
    {
        $data = Service::all()->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openSessionsCount()
    {
        $data = Session::WhereDoesntHave('privateSession')->WhereDoesntHave('publicSession')->where('status', 'active')->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openPrivateSessionsCount()
    {
        $data = PrivateSession::whereHas('session', function ($query) {
            $query->where('status', 'active');
        })->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function openPublicSessionsCount()
    {
        $data = PublicSession::whereHas('session', function ($query) {
            $query->where('status', 'active');
        })->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function totalSessionsCount()
    {
        $data = Session::all()->count();

        return response()->json($data, Response::HTTP_OK);
    }

    public function groupsCount()
    {
        $data = Group::all()->count();

        return response()->json($data, Response::HTTP_OK);
    }

}
