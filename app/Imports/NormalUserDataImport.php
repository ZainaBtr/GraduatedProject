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
        $userTableExistingRecord = User::where('fullName', $row['full_name'])->first();

        $normalUserTableExistingRecord = NormalUser::where('examinationNumber', $row['examination_number'])
            ->where('studySituation', $row['study_situation'])
            ->first();

        if ($userTableExistingRecord && $normalUserTableExistingRecord) {
            $errorMessage = 'Data already exists in the database';
            throw new \Exception($errorMessage);
        }

        $serviceYearAndSpecializationRecord = ServiceYearAndSpecialization::where('serviceYear', $row['year'])
            ->where('serviceSpecializationName', $row['specialization'])
            ->first();

        $password = Str::random(12);

        while(User::where('password', $password)->exists()) {
            $password = Str::random(12);
        }

        $user = new User([
            'fullName' => $row['full_name'],
            'password' => $password
        ]);
        $user->save();

        $userRecord = User::where('fullName', $row['full_name'])->first();

        $normalUser = new NormalUser([
            'userID' => $userRecord->id,
            'serviceYearAndSpecializationID' => $serviceYearAndSpecializationRecord->id,
            'examinationNumber' => $row['examination_number'],
            'studySituation' => $row['study_situation']
        ]);
        $normalUser->save();

        return null;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
