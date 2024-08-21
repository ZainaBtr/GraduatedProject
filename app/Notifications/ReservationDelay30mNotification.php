<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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
        return ['database' , 'firebase'];
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
            'privateSessionName' => $this->reservation->privateSession->session->sessionName,
            'reservationDate' => $this->reservation->reservationDate,
            'reservationStartTime' => $this->reservation->reservationStartTime,
            'reservationEndTime' => $this->reservation->reservationEndTime,
            'message' => 'The reservation for group ' . $this->reservation->groupID .
                ' in session name ' . $this->reservation->privateSession->session->sessionName .
                ' is delayed by more than 30 minutes.',
        ];
    }
}
