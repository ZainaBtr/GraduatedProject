<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SavedAnnouncement;
use Illuminate\Http\Response;

class SavedAnnouncementController extends Controller
{

    public function showAll()
    {
        $allRecords = Announcement::whereHas('savedAnnouncement', function ($query) {
            $query->where('userID', auth()->id());
        })
            ->with('service', 'file')->get();

        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function save(Announcement $announcement)
    {
        $data['userID'] = auth()->id();
        $data['announcementID'] = $announcement['id'];

        $recordStored = SavedAnnouncement::create($data);

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function unSave(SavedAnnouncement $savedAnnouncement)
    {
        $savedAnnouncement->delete();

        return response()->json(['message' => 'this announcement unsaved successfully']);
    }

}
