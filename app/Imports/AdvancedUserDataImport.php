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
        $userTableExistingRecord = User::where('fullName', $row['full_name'])->first();

        if ($userTableExistingRecord) {
            $errorMessage = 'Data already exists in the database';
            throw new \Exception($errorMessage);
        }

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
