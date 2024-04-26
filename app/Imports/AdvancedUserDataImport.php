<?php

namespace App\Imports;

use App\Models\AdvancedUser;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdvancedUserDataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $userTableExistingRecord = User::where('fullName', $row['fullname'])->first();

        if ($userTableExistingRecord) {
            $errorMessage = 'Data already exists in the database';
            throw new \Exception($errorMessage);
        }

        $user = new User([
            'fullName' => $row['fullname'],
            'password' => Str::random(12)
        ]);
        $user->save();

        $userRecord = User::where('fullName', $row['fullname'])->first();

        $advancedUser = new AdvancedUser([
            'userID' => $userRecord->id
        ]);
        $advancedUser->save();

        return null;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
