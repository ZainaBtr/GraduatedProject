<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\SavedAnnouncement;

class SavedAnnouncementService
{
    protected $controllerService;

    public function __construct(ControllerService $controllerService)
    {
        $this->controllerService = $controllerService;
    }

    public function showAll()
    {
        $allRecords = Announcement::with('savedAnnouncement', 'service', 'file')
            ->whereHas('savedAnnouncement', function ($query) {
                $query->where('userID', auth()->id());
            })->get();

        return $this->controllerService->getAnnouncementData($allRecords);
    }

    public function save(Announcement $announcement)
    {
        $data['userID'] = auth()->id();

        $data['announcementID'] = $announcement['id'];

        return SavedAnnouncement::create($data);
    }

    public function unSave(SavedAnnouncement $savedAnnouncement)
    {
        return $savedAnnouncement->delete();
    }
}
