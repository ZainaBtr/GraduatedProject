<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class AnnouncementNotification extends Notification
{
    use Queueable;

    protected $announcement;

    /**
     * Create a new notification instance.
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'New announcement' => $this->announcement->title,
            'service name' => $this->announcement->service->serviceName ?? null
        ];
    }

    public function toFirebase($notifiable)
    {
        $deviceToken = $notifiable->deviceToken;

        if ($deviceToken) {

            try {
                $messaging = Firebase::messaging();

                $serviceName = $this->announcement->service->serviceName ?? 'No Service Related';
                $title = $this->announcement->title;
                $body = "New announcement from {$serviceName}: {$title}";

                $notification = FirebaseNotification::create($title)
                    ->withBody($body);

                $message = CloudMessage::withTarget('token', $deviceToken)
                    ->withNotification($notification);

                $messaging->send($message);
            }
            catch (\Throwable $e) {
                \Log::error('Failed to send Firebase notification: ' . $e->getMessage());
            }
        }
        else {
            \Log::warning('No device token found for user: ' . $notifiable->id);
        }
    }
}
