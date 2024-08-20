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
        $formattedNotifications = $this->notificationService->getAllNotificationsForUser();

        return response()->json($formattedNotifications, 200);
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
