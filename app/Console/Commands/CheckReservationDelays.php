<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Models\PrivateReservation;
use App\Models\User;
use App\Notifications\ReservationDelay30mNotification;
use Carbon\Carbon;

class CheckReservationDelays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:reservation-delays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for reservation delays and notify session owner if any reservation is delayed by more than 30 minutes';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        $delayedReservations = PrivateReservation::whereDate('reservationDate', $now->toDateString())
            ->where('reservationEndTime', '<', $now->subMinutes(30)->toTimeString())
            ->where('privateReservationStatus', false)
            ->get();

        if ($delayedReservations->isNotEmpty()) {

            foreach ($delayedReservations as $reservation) {

                $user = User::where('id', $reservation->privateSession->session->userID)->first();

                if ($user) {

                    $notification = new ReservationDelay30mNotification($reservation);

                    Notification::send($user, $notification);

                    $notification->toFirebase($user);
                }
            }
        }
        $this->info('Checked reservation delays and sent notifications if needed.');
    }
}
