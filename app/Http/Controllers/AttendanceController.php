<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Service;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

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
        //
    }

    public function showOfOneService(Service $service)
    {
        //
    }

    public function showMyAttendanceOfOneService(Service $service)
    {
        //
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

        // Decode the password array from the session
        $passwords = json_decode($session->password, true) ?? [];

        if (in_array($password, $passwords)
            && Carbon::now()->toDateString() == $dateNow
            && Carbon::now()->between($timeNow->copy()->addMinutes(300), $timeNow)) {
            Attendance::create([
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

}
