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
                'New announcement' => $notification->data['New announcement'] ?? 'No Title',
                'service name' =>$notification->data['service name'] ?? 'No Service Related',
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
