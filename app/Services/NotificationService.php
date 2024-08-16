<?php

namespace App\Services;

use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    public function getAllNotificationsForUser()
    {
        $notifications = auth()->user()->notifications;

        return $notifications->map(function($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? 'No Title',
            ];
        });
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::findOrFail($id);

        $notification->markAsRead();

        return ['message' => 'Notification marked as read'];
    }
}
