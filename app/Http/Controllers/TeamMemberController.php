<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\TeamMember;
use App\Services\TeamMemberService;

class TeamMemberController extends Controller
{
    protected $teamMemberService;

    public function __construct(TeamMemberService $teamMemberService)
    {
        $this->teamMemberService = $teamMemberService;
    }

    public function delete(Group $group, TeamMember $teamMember)
    {
        return $this->teamMemberService->delete($group,$teamMember);
    }
}
