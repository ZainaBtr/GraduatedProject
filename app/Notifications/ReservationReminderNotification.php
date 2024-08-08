<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationReminderNotification extends Notification
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'reservationID' => $this->reservation->id,
            'groupID' => $this->reservation->groupID,
            'reservationDate' => $this->reservation->reservationDate,
            'reservationStartTime' => $this->reservation->reservationStartTime,
            'message' => 'Your reservation is coming up in less than 30 minutes.',
        ];
    }
}
