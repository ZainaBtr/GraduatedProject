<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Services\TeamMemberService;

class TeamMemberController extends Controller
{
    protected $teamMemberService;

    public function __construct(TeamMemberService $teamMemberService)
    {
        $this->teamMemberService = $teamMemberService;
    }

    public function delete(TeamMember $teamMember)
    {
        return $this->teamMemberService->delete($teamMember);
    }
}
