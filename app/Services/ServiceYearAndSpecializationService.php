<?php

namespace App\Services;

use App\Models\ServiceManager;
use App\Models\ServiceYearAndSpecialization;

class ServiceYearAndSpecializationService
{
    public function showAll()
    {
        return ServiceYearAndSpecialization::all();
    }

    public function add($validatedData)
    {
        return ServiceYearAndSpecialization::create($validatedData);
    }

    public function delete(ServiceYearAndSpecialization $record)
    {
        $record->delete();

        return ['message' => 'This service year and specialization deleted successfully'];
    }

    public function deleteAll()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            ServiceYearAndSpecialization::query()->delete();

            return ['message' => 'All records deleted successfully'];
        }
        return ['message' => 'You dont have the permission to delete all records in this table'];
    }
}
