<?php

namespace App\Console\Commands;

use App\Models\PrivateReservation;
use App\Models\TeamMember;
use App\Notifications\ReservationReminderNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class NotifyUpcomingReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:upcoming-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify team members when their reservation is coming up in less than 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $thirtyMinutesLater = $now->addMinutes(30)->toTimeString();

        // Find reservations starting in less than 30 minutes

        $upcomingReservations = PrivateReservation::whereDate('reservationDate', $now->toDateString())
            ->where('reservationStartTime', '<=', $thirtyMinutesLater)
            ->where('reservationStartTime', '>', $now->toTimeString())
            ->where('privateReservationStatus', false)
            ->get();

        foreach ($upcomingReservations as $reservation) {

            // Get all team members of the group

            $teamMembers = TeamMember::where('groupID', $reservation->groupID)->get();

            foreach ($teamMembers as $member) {
                Notification::send($member->normalUser, new ReservationReminderNotification($reservation));
            }
        }
        $this->info('Notified team members of upcoming reservations.');
    }
}
