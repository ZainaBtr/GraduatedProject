<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMember\TeamMember1;
use App\Http\Requests\TeamMember\TeamMember2;
use App\Http\Requests\TeamMember\TeamMember3;
use App\Models\Group;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{

    public function add(TeamMember1 $request, Group $group)
    {
        //
    }

    public function search(TeamMember2 $request)
    {
        //
    }

    public function updateSkills(TeamMember3 $request, TeamMember $teamMember)
    {
        //
    }

    public function delete(TeamMember $teamMember)
    {
        //
    }

}







