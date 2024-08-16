<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Group;
use App\Models\PrivateSession;
use App\Models\PublicSession;
use App\Models\Service;
use App\Models\Session;
use App\Models\User;

class StatisticService
{
    public function advancedUsersCount()
    {
        return User::whereHas('advancedUser')->count();
    }

    public function normalUsersCount()
    {
        return User::whereHas('normalUser')->count();
    }

    public function serviceManagersCount()
    {
        return User::whereHas('serviceManager')->count();
    }

    public function totalUsersCount()
    {
        return User::all()->count();
    }

    public function announcementsCount()
    {
        return Announcement::all()->count();
    }

    public function openServicesCount()
    {
        return Service::where('status', 1)->count();
    }

    public function closeServicesCount()
    {
        return Service::where('status', 0)->count();
    }

    public function totalServicesCount()
    {
        return Service::all()->count();
    }

    public function openSessionsCount()
    {
        return Session::WhereDoesntHave('privateSession')
            ->WhereDoesntHave('publicSession')
            ->where('status', 'active')
            ->count();
    }

    public function openPrivateSessionsCount()
    {
        return PrivateSession::whereHas('session', function ($query) {
            $query->where('status', 'active');
        })->count();
    }

    public function openPublicSessionsCount()
    {
        return PublicSession::whereHas('session', function ($query) {
            $query->where('status', 'active');
        })->count();
    }

    public function totalSessionsCount()
    {
        return Session::all()->count();
    }

    public function groupsCount()
    {
        return Group::all()->count();
    }
}
