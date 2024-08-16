<?php

namespace App\Services;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function getAllNotificationsForUser()
    {
        return Auth::user()->notifications;
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::findOrFail($id);

        $notification->markAsRead();

        return ['message' => 'Notification marked as read'];
    }
}
