<?php

namespace App\Imports;

use App\Models\NormalUser;
use App\Models\ServiceYearAndSpecialization;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NormalUserDataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $userTableExistingRecord = User::where('fullName', $row['fullname'])->first();

        $normalUserTableExistingRecord = NormalUser::where('examinationNumber', $row['examinationnumber'])
            ->where('studySituation', $row['studysituation'])
            ->first();

        if ($userTableExistingRecord && $normalUserTableExistingRecord) {
            $errorMessage = 'Data already exists in the database';
            throw new \Exception($errorMessage);
        }

        $serviceYearAndSpecializationRecord = ServiceYearAndSpecialization::where('serviceYear', $row['serviceyear'])
            ->where('serviceSpecializationName', $row['servicespecializationname'])
            ->first();

        $user = new User([
            'fullName' => $row['fullname'],
            'password' => Str::random(12)
        ]);
        $user->save();

        $normalUser = new NormalUser([
            'serviceYearAndSpecializationID' => $serviceYearAndSpecializationRecord->id,
            'examinationNumber' => $row['examinationnumber'],
            'studySituation' => $row['studysituation']
        ]);
        $normalUser->save();

        return null;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
