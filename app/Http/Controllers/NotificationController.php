<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getAllNotificationsForUser()
    {
        $notifications = $this->notificationService->getAllNotificationsForUser();

        if (request()->is('api/*')) {

            return response()->json($notifications, 200);
        }
        return view('', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $response = $this->notificationService->markAsRead($id);

        if (request()->is('api/*')) {

            return response()->json($response, Response::HTTP_OK);
        }
        return redirect()->back();
    }
}
