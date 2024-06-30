<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\NormalUser;
use App\Models\Service;
use App\Models\ServiceYearAndSpecialization;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
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
            return response()->json(['message'=>'Group Created Successfully'],201);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchNormalUser(Request $request)
    {
        $searchTerm = $request->input('fullName');

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
