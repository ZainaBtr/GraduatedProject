<?php

namespace App\Http\Controllers;
use App\Http\Requests\NormalUser\NormalUser1;
use App\Http\Requests\NormalUser\NormalUser2;
use App\Http\Requests\NormalUser\NormalUser4;
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
            'full_name' => $user->fullName,
            'email' => $user->email,
        ];
        $id= $user->normalUser->serviceYearAndSpecializationID;
        $serviceYearAndSpecialization=ServiceYearAndSpecialization::query()->where('id',$id)->get()->first();
        $additionalData = [
            'service year' => $serviceYearAndSpecialization->serviceYear,
            'service Specialization Name' => $serviceYearAndSpecialization->serviceSpecializationName,
            'examination_number' => $user->normalUser->examinationNumber,
            'study_situation' => $user->normalUser->studySituation,
            'skills' => $user->normalUser->skills,
            'birth_date' => $user->normalUser->birthDate,
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
            $userData = [
                'full_name' => $user->fullName,
                'email' => $user->email,
            ];

            $normalUser = $user->normalUser;
            $serviceYearAndSpecialization = ServiceYearAndSpecialization::find($normalUser->serviceYearAndSpecializationID);
            $additionalData = [
                'service year' => $serviceYearAndSpecialization ? $serviceYearAndSpecialization->serviceYear : null,
                'service_specialization' => $serviceYearAndSpecialization ? $serviceYearAndSpecialization->serviceSpecializationName : null,
                'examination_number' => $normalUser->examinationNumber,
                'study_situation' => $normalUser->studySituation,
                'skills' => $normalUser->skills,
                'birth_date' => $normalUser->birthDate,
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
        if(!$user){
            return response()->json(['message' => 'Account Not Found']);
        }
        $data=$this->createToken($user);
        return response()->json($data,Response::HTTP_OK);
    }

   public function completeAccount2(NormalUser2 $request)
    {
        $user = Auth::user();
        $user->normalUser()->update($request->validated());
        return response()->json($user,Response::HTTP_OK);
    }

    // complete account 3 = set email in user controller;

   public function completeAccount4(NormalUser4 $request)
    {
        $user = Auth::user();
        $user->normalUser()->update(['skills'=> $request['skills']]);
        return response()->json($user,Response::HTTP_OK);
    }

    public function deleteAllAccounts( )
    {
        User::whereHas('normalUser')->delete();

        if(request()->is('api/*')){
            return response()->json(['message' => ' Normal Users Deleted Successfully']);
        }
        return view('');
    }

}
