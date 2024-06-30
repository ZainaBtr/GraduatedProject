<?php

namespace App\Http\Controllers;

use App\Exports\ShowAttendanceOfOneServiceExport;
use App\Models\Attendance;
use App\Models\NormalUser;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{

    public function showSessionQr(Session $session)
    {
        $dateNow = Carbon::now()->toDateString();
        $timeNow = Carbon::now();

        $startSession = Carbon::parse($session['sessionStartTime']);
        $closeSession = Carbon::parse($session['sessionEndTime']);

        if ($session['sessionDate'] === $dateNow && $timeNow->between($startSession, $closeSession)) {

            $password = Str::random(12);

            $qrCodeData = "{$session->id}|{$password}|{$dateNow}|{$timeNow->toTimeString()}";

            $qrCode = QrCode::create($qrCodeData);

            $writer = new PngWriter();

            $qrCodeImage = $writer->write($qrCode)->getString();

            $base64Image = base64_encode($qrCodeImage);

            $currentPasswords = json_decode($session->password, true) ?? [];

            $currentPasswords[] = $password;

            $session->update(['password' => json_encode($currentPasswords)]);

            return response()->json([
                'image' => $base64Image
            ], 200);
        } else {
            return response()->json(['message' => 'Session is not active or time is incorrect.'], 403);
        }
    }

    public function showOfOneSession(Session $session)
    {
        $allRecords = Attendance::where('sessionID', $session['id'])
            ->with(['normalUser.user'])
            ->get();

        $allRecords = $allRecords->map(function ($attendance) {
            $attendance->normalUserName = $attendance->normalUser->user->fullName;

            unset($attendance->normalUser);

            return $attendance->only(['id', 'sessionID', 'normalUserName', 'created_at', 'updated_at']);
        });
        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function showOfOneService(Service $service)
    {
        $sessions = Session::where('serviceID', $service['id'])->get();

        $sessionCount = $sessions->count();

        $attendanceData = [];

        foreach ($sessions as $session) {

            $attendances = Attendance::where('sessionID', $session['id'])
                ->with(['normalUser.user'])
                ->get();

            foreach ($attendances as $attendance) {

                $userID = $attendance->normalUser->user->id;

                $userName = $attendance->normalUser->user->fullName;

                if (!isset($attendanceData[$userID])) {

                    $attendanceData[$userID] = [
                        'userID' => $userID,
                        'normalUserName' => $userName,
                        'attendanceCount' => 0,
                    ];
                }
                $attendanceData[$userID]['attendanceCount']++;
            }
        }
        $allRecords = array_map(function ($data) use ($sessionCount) {
            return [
                'userID' => $data['userID'],
                'normalUserName' => $data['normalUserName'],
                'attendanceCount' => $data['attendanceCount'],
                'sessionsCount' => $sessionCount,
                'attendancePercentage' => ($data['attendanceCount'] / $sessionCount) * 100,
            ];
        }, $attendanceData);

        return response()->json(array_values($allRecords), Response::HTTP_OK);
    }

    public function showMyAttendanceOfOneService(Service $service)
    {
        $sessions = Session::where('serviceID', $service['id'])->get();

        $sessionCount = $sessions->count();

        $attendanceData = [];

        $attendanceCount = 0;

        foreach ($sessions as $session) {

            $normalUser = NormalUser::where('userID', auth()->id())->first();

            $attendances = Attendance::where('sessionID', $session['id'])
                ->where('normalUserID', $normalUser['id'])
                ->first();
            if($attendances) {
                $attendanceCount++;
                $attendanceData[] = [
                    'sessionID' => $session['id'],
                    'sessionName' => $session['sessionName']
                ];
            }
        }
        $allRecords = [
            'attendanceData' => $attendanceData,
            'attendanceCount' => $attendanceCount,
            'sessionsCount' => $sessionCount,
            'attendancePercentage' => $attendanceCount / $sessionCount * 100,
        ];
        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function scanQr(Request $request)
    {
        $sessionId = $request->input('sessionID');
        $password = $request->input('password');
        $dateNow = $request->input('dateNow');
        $timeNow = Carbon::parse($request->input('timeNow'));

        $session = Session::find($sessionId);

        if (!$session) {
            return response()->json(['message' => 'Session not found.'], 404);
        }

        $passwords = json_decode($session->password, true) ?? [];

        $normalUser = NormalUser::where('userID', auth()->id())->first();

        if (in_array($password, $passwords)
            && Carbon::now()->toDateString() == $dateNow
            && Carbon::now()->between($timeNow->copy()->addMinutes(300), $timeNow)) {
            Attendance::create([
                'normalUserID' => $normalUser->id,
                'sessionID' => $sessionId,
            ]);

            return response()->json(['message' => 'Attendance recorded successfully.'], 200);
        }

        $failureReason = [];
        if (!in_array($password, $passwords)) {
            $failureReason[] = 'Invalid password';
        }
        if (Carbon::now()->toDateString() != $dateNow) {
            $failureReason[] = 'Invalid date';
        }
        if (!Carbon::now()->between($timeNow->copy()->addMinutes(300), $timeNow)) {
            $failureReason[] = 'Invalid time';
        }

        return response()->json([
            'message' => 'Attendance is not recorded successfully.',
            'reasons' => $failureReason
        ], 400);
    }

    public function showAttendanceOfOneServiceInExcel(Service $service)
    {
        return Excel::download(new ShowAttendanceOfOneServiceExport($service), 'attendance.xlsx');
    }

}
