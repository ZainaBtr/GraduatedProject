<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SavedAnnouncement;
use App\Services\SavedAnnouncementService;
use Illuminate\Http\Response;

class SavedAnnouncementController extends Controller
{
    protected $savedAnnouncementService;

    public function __construct(SavedAnnouncementService $savedAnnouncementService)
    {
        $this->savedAnnouncementService = $savedAnnouncementService;
    }

    public function showAll()
    {
        $allRecords = $this->savedAnnouncementService->showAll();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('',compact('allRecords'));
    }

    public function save(Announcement $announcement)
    {
        $recordStored = $this->savedAnnouncementService->save($announcement);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function unSave(SavedAnnouncement $savedAnnouncement)
    {
        $response = $this->savedAnnouncementService->unSave($savedAnnouncement);

        return response()->json($response);
    }
}
