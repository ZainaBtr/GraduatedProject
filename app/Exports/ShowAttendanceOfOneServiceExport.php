<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Service;
use App\Models\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShowAttendanceOfOneServiceExport implements FromCollection, WithHeadings
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function collection()
    {
        $sessions = Session::where('serviceID', $this->service['id'])->get();

        $sessionCount = $sessions->count();

        $attendanceData = [];

        foreach ($sessions as $session) {
            $attendances = Attendance::where('sessionID', $session->id)
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
        $allRecords = collect(array_map(function ($data) use ($sessionCount) {
            return [
                'userID' => $data['userID'],
                'normalUserName' => $data['normalUserName'],
                'attendanceCount' => $data['attendanceCount'],
                'sessionsCount' => $sessionCount,
                'attendancePercentage' => ($data['attendanceCount'] / $sessionCount) * 100,
            ];
        }, $attendanceData));

        return $allRecords;
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Normal User Name',
            'Attendance Count',
            'Sessions Count',
            'Attendance Percentage',
        ];
    }
}
