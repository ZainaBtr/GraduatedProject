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
    public function countAdvancedUsers()
    {
        return User::whereHas('advancedUser')->count();
    }

    public function countNormalUsers()
    {
        return User::whereHas('normalUser')->count();
    }

    public function countServiceManagers()
    {
        return User::whereHas('serviceManager')->count();
    }

    public function countTotalUsers()
    {
        return User::all()->count();
    }

    public function countAnnouncements()
    {
        return Announcement::all()->count();
    }

    public function countOpenServices()
    {
        return Service::where('status', 1)->count();
    }

    public function countCloseServices()
    {
        return Service::where('status', 0)->count();
    }

    public function countTotalServices()
    {
        return Service::all()->count();
    }

    public function countOpenSessions()
    {
        return Session::WhereDoesntHave('privateSession')
            ->WhereDoesntHave('publicSession')
            ->where('status', 'active')
            ->count();
    }

    public function countOpenPrivateSessions()
    {
        return PrivateSession::whereHas('session', function ($query) {
            $query->where('status', 'active');
        })->count();
    }

    public function countOpenPublicSessions()
    {
        return PublicSession::whereHas('session', function ($query) {
            $query->where('status', 'active');
        })->count();
    }

    public function countTotalSessions()
    {
        return Session::all()->count();
    }

    public function countGroups()
    {
        return Group::all()->count();
    }
}
