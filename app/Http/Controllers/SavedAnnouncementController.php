<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SavedAnnouncement;
use Illuminate\Http\Response;

class SavedAnnouncementController extends Controller
{

    public function showAll()
    {
        $allRecords = SavedAnnouncement::where('userID', auth()->id())
            ->with('announcement', 'announcement.service', 'announcement.file')->get();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('');
    }

    public function save(Announcement $announcement)
    {
        $data['userID'] = auth()->id();
        $data['announcementID'] = $announcement['id'];

        $recordStored = SavedAnnouncement::create($data);

        if (request()->is('api/*')) {
            return response()->json($recordStored, Response::HTTP_OK);
        }
        return view('');
    }

    public function unSave(SavedAnnouncement $savedAnnouncement)
    {
        $savedAnnouncement->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'this announcement unsaved successfully']);
        }
        return view('');
    }

}
