<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class ReservationDelay30mNotification extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
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

    public function toDatabase($notifiable)
    {
        return [
            'reservationID' => $this->reservation->id,
            'groupID' => $this->reservation->groupID,
            'privateSessionName' => $this->reservation->privateSession->session->sessionName,
            'reservationDate' => $this->reservation->reservationDate,
            'reservationStartTime' => $this->reservation->reservationStartTime,
            'reservationEndTime' => $this->reservation->reservationEndTime,
            'message' => 'The reservation for group ' . $this->reservation->groupID .
                ' in session name ' . $this->reservation->privateSession->session->sessionName .
                ' is delayed by more than 30 minutes.',
        ];
    }

    public function toFirebase($notifiable)
    {
        $deviceToken = $notifiable->deviceToken;

        if ($deviceToken) {
            try {
                $messaging = Firebase::messaging();

                $sessionName = $this->reservation->privateSession->session->sessionName ?? 'No Session Name';
                $title = 'Reservation Delay';
                $body = "The reservation for group {$this->reservation->groupID} in session {$sessionName} is delayed by more than 30 minutes.";

                $notification = FirebaseNotification::create($title)
                    ->withBody($body);

                $message = CloudMessage::withTarget('token', $deviceToken)
                    ->withNotification($notification)
                    ->withData([
                        'reservationID' => $this->reservation->id,
                        'groupID' => $this->reservation->groupID,
                        'privateSessionName' => $this->reservation->privateSession->session->sessionName,
                        'reservationDate' => $this->reservation->reservationDate,
                        'reservationStartTime' => $this->reservation->reservationStartTime,
                        'reservationEndTime' => $this->reservation->reservationEndTime,
                    ]);
                $messaging->send($message);
            }
            catch (\Throwable $e) {
                \Log::error('Failed to send Firebase notification: ' . $e->getMessage());
            }
        } else {
            \Log::warning('No device token found for user: ' . $notifiable->id);
        }
    }
}
