<?php

namespace App\Services;

use App\Models\TeamMember;

class TeamMemberService
{
    public function delete(TeamMember $teamMember)
    {
        $teamMember->delete();

        return ['message'=>'team member removed successfully'];
    }
}
