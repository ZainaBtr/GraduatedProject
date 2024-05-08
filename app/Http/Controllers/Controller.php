<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\File1;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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
