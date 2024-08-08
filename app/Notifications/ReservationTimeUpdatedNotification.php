<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationTimeUpdatedNotification extends Notification
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
            'newReservationDate' => $this->reservation->reservationDate,
            'newReservationStartTime' => $this->reservation->reservationStartTime,
            'newReservationEndTime' => $this->reservation->reservationEndTime,
            'message' => 'Your reservation has been delayed. The new time is ' .
                $this->reservation->reservationStartTime . ' - ' .
                $this->reservation->reservationEndTime . ' on ' .
                $this->reservation->reservationDate . '.',
        ];
    }
}
