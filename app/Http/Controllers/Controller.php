<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\Announcement1;
use App\Http\Requests\Announcement\Announcement2;
use App\Http\Requests\File\File1;
use App\Http\Requests\User\User3;
use App\Mail\VerifyEmail;
use App\Models\FakeReservation;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Announcement;
use App\Models\File;
use App\Models\InterestedService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Email;
use App\Http\Requests\User\User4;
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

    public function createToken(User $user)
    {
        $tokenResult = $user->createToken('Personal Access Token');

        $data["user"]= $user;

        $data["token_type"]='Bearer';

        $data["access_token"]=$tokenResult->accessToken;

        return $data;
    }

    public function checkToken(User4 $request)
    {
        $select = DB::table('password_reset_tokens')->where('token', $request['token']);

        if ($select->get()->isEmpty()) {
            return false;
        }
        return $select->value('email');
    }

    protected function importUsersFile(File1 $request, $importClass)
    {
        if ($request['file']->isValid()) {
            Excel::import(new $importClass(), $request['file']);

            if(request()->is('api/*')) {
                return response()->json(['message' => 'File imported successfully'], 200);
            }
        }
        else {
            if(request()->is('api/*')) {
                return response()->json(['message' => 'Failed to upload file'], 500);
            }
        }
    }

    function checkIsInterested($serviceId, $userId)
    {
        $exists = InterestedService::where('serviceID', $serviceId)
            ->where('userID', $userId)
            ->exists();

        return $exists ? 1 : 0;
    }

    protected function getServiceData($allRecords)
    {
        return $allRecords->map(function ($record) {
            $advancedUserRoles = $record->assignedService->map(function ($assignedService) {
                return [
                    'fullName' => $assignedService->user->fullName,
                    'roles' => $assignedService->assignedRole->pluck('role.roleName')
                ];
            });

            $interestedServices = $record->interestedService;

            $isInterested = $interestedServices->contains(function ($interestedService) use ($record) {
                return $this->checkIsInterested($record['id'], $interestedService->userID);
            });

            return [
                'id' => $record['id'],
                'serviceManagerName' => $record->serviceManager->user->fullName,
                'parentServiceID' =>$record['parentServiceID'],
                'parentServiceName' => $record->parentService?->serviceName,
                'serviceYearName' => $record->serviceYearAndSpecialization->serviceYear,
                'serviceSpecializationName' => $record->serviceYearAndSpecialization->serviceSpecializationName,
                'serviceName' => $record->serviceName,
                'serviceDescription' => $record->serviceDescription,
                'serviceType' => $record->serviceType,
                'minimumNumberOfGroupMembers' => $record->minimumNumberOfGroupMembers,
                'maximumNumberOfGroupMembers' => $record->maximumNumberOfGroupMembers,
                'statusName' => $record->status == 1 ? 'Effective' : 'Not Effective',
                'advancedUsersWithRoles' => $advancedUserRoles,
                'isInterested' => $isInterested ? 1 : 0
            ];
        });
    }

    public function createFakeReservations($session): array
    {
        $privateSession = $session->privateSession;
        $sessionStartTime = Carbon::parse($session->sessionStartTime);
        $sessionEndTime = Carbon::parse($session->sessionEndTime);
        $durationForEachReservation = Carbon::parse($privateSession->durationForEachReservation);

        $totalSessionDurationMinutes = $sessionEndTime->diffInMinutes($sessionStartTime);
        $reservationDurationMinutes = $durationForEachReservation->hour * 60 + $durationForEachReservation->minute;
        $numberOfReservations = intval($totalSessionDurationMinutes / $reservationDurationMinutes);

        $reservations = [];
        for ($i = 0; $i < $numberOfReservations; $i++) {
            $reservationStartTime = $sessionStartTime->copy()->addMinutes($i * $reservationDurationMinutes);
            $reservationEndTime = $reservationStartTime->copy()->addMinutes($reservationDurationMinutes);

            $reservationStartTimeFormatted = $reservationStartTime->format('H:i');
            $reservationEndTimeFormatted = $reservationEndTime->format('H:i');

            $reservations[] = FakeReservation::create([
                'privateSessionID' => $privateSession->id,
                'reservationStartTime' => $reservationStartTimeFormatted,
                'reservationEndTime' => $reservationEndTimeFormatted
            ]);
        }

        return $reservations;
    }

    private function storeFile($request, $announcement)
    {
        $newFile = $request->file('file');

        $data['announcementID'] = $announcement->id;

        $data['fileName'] = $newFile->getClientOriginalName();

        $data['filePath'] = $newFile->storeAs('uploads', $data['fileName'], 'public');

        return File::create($data);
    }

    public function addFileInAnnouncement(Announcement1 $request, Announcement $announcement)
    {
        $recordStored = $this->storeFile($request, $announcement);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function addFileFromServiceInAnnouncement(Announcement2 $request, Announcement $announcement)
    {
        $recordStored = $this->storeFile($request, $announcement);

        return response()->json($recordStored, Response::HTTP_OK);
    }

}
