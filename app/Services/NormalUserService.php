<?php

namespace App\Services;

use App\Http\Requests\NormalUser\NormalUser1;
use App\Http\Requests\NormalUser\NormalUser2;
use App\Http\Requests\NormalUser\NormalUser4;
use App\Models\ServiceManager;
use App\Models\ServiceYearAndSpecialization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NormalUserService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showProfile()
    {
        $user= Auth::user();

        $userData = [
            'fullName' => $user->fullName,
            'email' => $user->email,
        ];
        $id = $user->normalUser->serviceYearAndSpecializationID;

        $serviceYearAndSpecialization=ServiceYearAndSpecialization::query()->where('id',$id)->get()->first();

        $additionalData = [
            'serviceYear' => $serviceYearAndSpecialization->serviceYear,
            'serviceSpecializationName' => $serviceYearAndSpecialization->serviceSpecializationName,
            'examinationNumber' => $user->normalUser->examinationNumber,
            'studySituation' => $user->normalUser->studySituation,
            'skills' => $user->normalUser->skills,
            'birthDate' => $user->normalUser->birthDate,
        ];
        return array_merge($userData, $additionalData);
    }

    public function showAll()
    {
        $users = User::whereHas('normalUser')->get();

        $usersData = [];

        foreach ($users as $user) {

            $normalUser = $user->normalUser;

            $serviceYearAndSpecialization = ServiceYearAndSpecialization::find($normalUser->serviceYearAndSpecializationID);

            if ($normalUser->isAccountCompleted == 0) {

                $usersData[] = [
                    'id' => $normalUser->id,
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'password' => $user->password,
                    'isAccountCompleted'=>$normalUser->isAccountCompleted,
                    'serviceYear' => $serviceYearAndSpecialization->serviceYear,
                    'serviceSpecialization' => $serviceYearAndSpecialization->serviceSpecializationName,
                    'examinationNumber' => $normalUser->examinationNumber,
                    'studySituation' => $normalUser->studySituation,
                    'skills' => $normalUser->skills,
                    'birthDate' => $normalUser->birthDate
                ];
            }
            else {
                $usersData[] = [
                    'id' => $normalUser->id,
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'isAccountCompleted'=>$normalUser->isAccountCompleted,
                    'serviceYear' => $serviceYearAndSpecialization->serviceYear,
                    'serviceSpecialization' => $serviceYearAndSpecialization->serviceSpecializationName,
                    'examinationNumber' => $normalUser->examinationNumber,
                    'studySituation' => $normalUser->studySituation,
                    'skills' => $normalUser->skills,
                    'birthDate' => $normalUser->birthDate
                ];
            }
        }
        return $usersData;
    }

    public function completeAccount1(NormalUser1 $request)
    {
        $user = User::where('password',$request['password'])->first();

        if(!$user) {

            return ['message' => 'Account Not Found'];
        }
        return $this->controllerService->createToken($user);
    }

    public function completeAccount2(NormalUser2 $request)
    {
        $user = Auth::user();

        return $user->normalUser()->update($request->validated());
    }

    // complete account 3 = update email in  AuthController;

    public function completeAccount4(NormalUser4 $request)
    {
        $user = Auth::user();

        return $user->normalUser()->update(['skills'=> $request['skills']]);
    }

    public function deleteAllAccounts( )
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            User::whereHas('normalUser')->delete();

            return ['message' => ' Normal Users Deleted Successfully'];
        }
        return ['message' => 'you dont have the permission to delete all records in this table'];
    }
}
