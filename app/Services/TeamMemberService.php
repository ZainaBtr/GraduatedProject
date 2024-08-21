<?php

namespace App\Services;

use App\Models\Group;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;

class TeamMemberService
{
    public function delete(Group $group, TeamMember $teamMember)
    {
        $user = Auth::user();
        $normalUserID = $user->normalUser->id;
        $isMember = $group->teamMembers->where('normalUserID', $normalUserID)->first();

        if (!$isMember) {
            return response()->json(['message' => 'You are not a member of the group'], 400);
        }
        $teamMember->delete();

        $remainingMembers = $group->teamMembers()->count();

        if ($remainingMembers == 0) {
            $group->delete();
        }

        return response()->json(['message' => 'Team member removed successfully'], 200);
    }
}
