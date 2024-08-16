<?php

namespace App\Services;

use App\Http\Requests\Announcement\Announcement1;
use App\Http\Requests\Announcement\Announcement2;
use App\Http\Requests\File\File1;
use App\Http\Requests\User\User4;
use App\Mail\VerifyEmail;
use App\Models\Announcement;
use App\Models\FakeReservation;
use App\Models\File;
use App\Models\InterestedService;
use App\Models\PublicReservation;
use App\Models\PublicSession;
use App\Models\SavedAnnouncement;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ControllerService
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

    public function importUsersFile(File1 $request, $importClass)
    {
        if ($request['file']->isValid()) {

            Excel::import(new $importClass(), $request['file']);

            return ['message' => 'File imported successfully'];
        }
        else {
            return ['message' => 'Failed to upload file'];
        }
    }

    public function checkIsInterested($serviceId, $userId)
    {
        $exists = InterestedService::where('serviceID', $serviceId)
            ->where('userID', $userId)
            ->exists();

        return $exists ? 1 : 0;
    }

    public function getServiceData($allRecords)
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

            if($isInterested) {

                $interestedService = $interestedServices->firstWhere('userID', auth()->id());
            }
            else {
                $interestedService = null;
            }

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
                'isInterested' => $isInterested ? 1 : 0,
                'interestedService' => $interestedService
            ];
        });
    }

    public function checkIsSaved($announcementId, $userId)
    {
        $exists = SavedAnnouncement::where('announcementID', $announcementId)
            ->where('userID', $userId)
            ->exists();

        return $exists ? 1 : 0;
    }

    public function getAnnouncementData($allRecords)
    {
        return $allRecords->map(function ($record) {

            $isSaved = $this->checkIsSaved($record['id'], $record->userID);

            if($isSaved) {

                $savedAnnouncement = $record->firstWhere('userID', auth()->id());
            }
            else {
                $savedAnnouncement = null;
            }
            return [
                'isSaved' => $isSaved ? 1 : 0,
                'id' => $record['id'],
                'serviceID' => $record['serviceID'] ?? null,
                'userID' => $record['userID'],
                'title' => $record['title'] ?? null,
                'description' => $record['description'] ?? null,
                'service' => $record->service ?? null,
                'file' => $record->file ?? null,
                'SavedAnnouncement' => $savedAnnouncement
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

    public function storeFile($request, $announcement)
    {
        $newFile = $request->file('file');

        $data['announcementID'] = $announcement->id;

        $data['fileName'] = $newFile->getClientOriginalName();

        $data['filePath'] = $newFile->storeAs('uploads', $data['fileName'], 'public');

        return File::create($data);
    }

    public function addFileInAnnouncement(Announcement1 $request, Announcement $announcement)
    {
        return $this->storeFile($request, $announcement);
    }

    public function addFileFromServiceInAnnouncement(Announcement2 $request, Announcement $announcement)
    {
        return $this->storeFile($request, $announcement);
    }

    public function showMyReservationsByType($serviceType)
    {
        $userID = Auth::id();

        $services = Service::where('serviceType', $serviceType)->pluck('id');

        $publicSessions = PublicSession::whereHas('session', function ($query) use ($services) {
            $query->whereIn('serviceID', $services);})->pluck('id');

        $myReservations = PublicReservation::where('userID', $userID)->whereIn('publicSessionID', $publicSessions)
            ->with(['publicSession.session.service.parentService'])->get();

        $reservationsDetails = $myReservations->map(function ($reservation) {

            $serviceName = $reservation->publicSession->session->service->serviceName;

            $parentServiceName = $reservation->publicSession->session->service->parentService->serviceName ?? null;

            if ($parentServiceName) {
                $serviceName = $parentServiceName . ' - ' . $serviceName;
            }
            return [
                'reservationID' => $reservation->id,
                'sessionName' => $reservation->publicSession->session->sessionName,
                'serviceName' => $serviceName,
                'sessionDate' => $reservation->publicSession->session->sessionDate,
                'sessionStartTime' => $reservation->publicSession->session->sessionStartTime,
                'sessionEndTime' => $reservation->publicSession->session->sessionEndTime,
            ];
        });
        return $reservationsDetails;
    }

    public function getSwapRequestsDetails($swapRequests)
    {
        return $swapRequests->map(function ($swapRequest) {

            $serviceName = $swapRequest->privateReservation->privateSession->session->service->serviceName;

            $parentServiceName = $swapRequest->privateReservation->privateSession->session->service->parentService->serviceName ?? '';

            return [
                'swapRequestID' => $swapRequest->id,
                'serviceName' => trim("$serviceName $parentServiceName"),
                'senderReservation' => [
                    'id' => $swapRequest->privateReservation->id,
                    'reservationDate' => $swapRequest->privateReservation->reservationDate,
                    'reservationStartTime' => $swapRequest->privateReservation->reservationStartTime,
                    'reservationEndTime' => $swapRequest->privateReservation->reservationEndTime,
                ],
                'status' => $swapRequest->status,
            ];
        });
    }
}
