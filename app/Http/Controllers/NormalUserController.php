<?php

namespace App\Http\Controllers;
use App\Http\Requests\NormalUser\NormalUser1;
use App\Http\Requests\NormalUser\NormalUser2;
use App\Http\Requests\NormalUser\NormalUser4;
use App\Models\ServiceManager;
use App\Models\ServiceYearAndSpecialization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NormalUserController extends Controller
{

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
        $responseData = array_merge($userData, $additionalData);

        if(request()->is('api/*')){
            return response()->json($responseData,200);
        }
        return view('');
    }

    public function showAll()
    {
        $users = User::whereHas('normalUser')->get();

        $usersData = [];

        foreach ($users as $user) {

            $normalUser = $user->normalUser;

            if ($normalUser->isAccountCompleted == 0) {
                $userData[] = [
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'password' => $user->password,
                    'isAccountCompleted'=>$normalUser->isAccountCompleted
                ];
            }
            else {
                $userData[] = [
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'isAccountCompleted'=>$normalUser->isAccountCompleted
                ];
            }
            $serviceYearAndSpecialization = ServiceYearAndSpecialization::find($normalUser->serviceYearAndSpecializationID);

            $additionalData = [
                'serviceYear' => $serviceYearAndSpecialization->serviceYear,
                'serviceSpecialization' => $serviceYearAndSpecialization->serviceSpecializationName,
                'examinationNumber' => $normalUser->examinationNumber,
                'studySituation' => $normalUser->studySituation,
                'skills' => $normalUser->skills,
                'birthDate' => $normalUser->birthDate,
            ];
            $usersData[] = array_merge($userData, $additionalData);
        }
        if (request()->is('api/*')) {
            return response()->json($usersData, 200);
        }
        return view('');
    }

    public function completeAccount1(NormalUser1 $request)
    {
        $user = User::where('password',$request['password'])->first();

        if(!$user) {
            return response()->json(['message' => 'Account Not Found']);
        }
        $data=$this->createToken($user);

        response()->json($data,Response::HTTP_OK);
    }

   public function completeAccount2(NormalUser2 $request)
    {
        $user = Auth::user();

        $user->normalUser()->update($request->validated());

        return response()->json($user,Response::HTTP_OK);
    }

    // complete account 3 = update email in  AuthController;

   public function completeAccount4(NormalUser4 $request)
    {
        $user = Auth::user();

        $user->normalUser()->update(['skills'=> $request['skills']]);

        return response()->json($user,Response::HTTP_OK);
    }

    public function deleteAllAccounts( )
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            User::whereHas('normalUser')->delete();

            if (request()->is('api/*')) {
                return response()->json(['message' => ' Normal Users Deleted Successfully']);
            }
            return view('');
        }
        return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
    }

}
