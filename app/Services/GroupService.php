<?php

namespace App\Services;

use App\Http\Requests\Group\Group1;
use App\Models\Group;
use App\Models\NormalUser;
use App\Models\Service;
use App\Models\ServiceYearAndSpecialization;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupService
{
    public function showAll(Service $service)
    {
        $groups = Group::where('serviceID', $service->id)
            ->with(['teamMembers.normalUser.user'])
            ->get();

        return response()->json($groups->map(function($group) {
            return [
                'group_id' => $group->id,
                'members' => $group->teamMembers->map(function($member) {

                    return [
                        'teamMemberID'=>$member->id,
                        'normalUserID'=>$member->normalUser->id,
                        'memberName'=>$member->normalUser->user->fullName
                    ];
                }),
            ];
        }));
    }

    public function showMy()
    {
        $user = Auth::user();

        $normalUser = $user->normalUser;

        $groups = Group::whereHas('teamMembers', function ($query) use ($normalUser) {
            $query->where('normalUserID', $normalUser->id);
        })->with(['service.parentService', 'teamMembers.normalUser.user'])
            ->get();

        return response()->json($groups->map(function ($group) {
            return [
                'group_id' => $group->id,
                'service_name' => $group->service->serviceName,
                'parent_service_name' => $group->service->parentService ? $group->service->parentService->serviceName : null,
                'members' => $group->teamMembers->map(function ($member) {
                    return [
                        'normalUserID'=>$member->normalUser->id,
                        'memberName'=>$member->normalUser->user->fullName
                    ];
                }),
            ];
        }));
    }

    public function create(Service $service)
    {
        $user=Auth::user();

        $normalUser=$user->normalUser;

        $existingGroup = Group::where('serviceID', $service->id)
            ->whereHas('teamMembers', function ($query) use ($normalUser) {
                $query->where('normalUserID', $normalUser->id);
            })->first();

        if ($existingGroup) {
            return ['message' => 'you already have a group for this service'];
        }
        DB::beginTransaction();

        try{
            $group= Group::create([
                'serviceID'=>$service->id
            ]);
            TeamMember::create([
                'normalUserID'=>$normalUser->id,
                'groupID'=>$group->id
            ]);
            DB::commit();

            return ['message'=>'Group Created Successfully'];
        }
        catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function searchNormalUser(Group1 $request)
    {
        $request = $request->validated();

        $searchTerm = $request['fullName'];

        $users = User::where('fullName', 'LIKE', "%{$searchTerm}%")
            ->whereHas('normalUser')
            ->with('normalUser')
            ->get();

        return response()->json($users->map(function($user) {
            return [
                'normalUserId' => $user->normalUser->id,
                'fullName' => $user->fullName,
            ];
        }));
    }

    public function getNormalUserDetails(NormalUser $normalUser)
    {
        $user = $normalUser->user;

        $serviceYearAndSpecialization =ServiceYearAndSpecialization::where(
            'id',$normalUser->serviceYearAndSpecializationID
        )->first();

        return response()->json([
            'normalUserID' => $normalUser->id,
            'fullName' => $user->fullName,
            'serviceYear' => $serviceYearAndSpecialization->serviceYear,
            'serviceSpecialization' => $serviceYearAndSpecialization->serviceSpecializationName,
            'skills' => $normalUser->skills,
        ]);
    }
}
