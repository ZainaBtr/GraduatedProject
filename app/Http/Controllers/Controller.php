<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\User4;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\File\File1;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendEmail($email)
    {
        $verify = DB::table('password_reset_tokens')->where([['email',$email]]);
        if ($verify->exists()) {
            $verify->delete();
        }
        $pin = rand(100000, 999999);
        DB::table('password_reset_tokens')->insert(['email' => $email, 'token' => $pin ]);
        Mail::to($email)->send(new VerifyEmail($pin));
    }

    public function createToken(User $user){
        $tokenResult = $user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return $data;
    }

    public function checkToken(User4 $request){
        $select = DB::table('password_reset_tokens')
            ->where('token', $request['token']);

        if ($select->get()->isEmpty()) {
            return false;
        }
        return $select->value('email');
    }

    protected function importUsersFile(File1 $request, $importClass)
    {
        $validated = $request->validated();

        if ($validated['file']->isValid()) {
            Excel::import(new $importClass(), $validated['file']);

            return response()->json(['message' => 'File imported successfully'], 200);
        }
        else {
            return response()->json(['message' => 'Failed to upload file'], 500);
        }
    }

    protected function getServiceData($allRecords)
    {
        return $allRecords->map(function ($record) {
            $advancedUserRoles = $record->assignedService->map(function ($assignedService) {
                return [
                    'fullName' => $assignedService->advancedUser->user->fullName,
                    'roles' => $assignedService->assignedRole->pluck('role.roleName')
                ];
            });

            return [
                'id' => $record['id'],
                'serviceManagerName' => $record->serviceManager->user->fullName,
                'parentServiceName' => $record->parentService?->serviceName,
                'serviceYearName' => $record->serviceYearAndSpecialization->serviceYear,
                'serviceSpecializationName' => $record->serviceYearAndSpecialization->serviceSpecializationName,
                'serviceName' => $record->serviceName,
                'serviceDescription' => $record->serviceDescription,
                'serviceType' => $record->serviceType,
                'minimumNumberOfGroupMembers' => $record->minimumNumberOfGroupMembers,
                'maximumNumberOfGroupMembers' => $record->maximumNumberOfGroupMembers,
                'statusName' => $record->status == 1 ? 'Effective' : 'Not Effective',
                'advancedUsersWithRoles' => $advancedUserRoles
            ];
        });
    }
}
