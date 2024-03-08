<?php

namespace App\Listeners;

use App\Events\ReservationEvent;
use App\Models\Book;
use App\Models\User;
use App\Notifications\ReservationNotification;
use Exception;
use Illuminate\Support\Facades\Log;

class ReservationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReservationEvent $event)
    {
        $librarianUsers = User::where('role_id', 2)->get();

        foreach ($librarianUsers as $librarian) {
            try {

                $user = User::find($event->reservationData['user_id']);
                $book = Book::find($event->reservationData['book_id']);

                if ($user && $book) {

                    $event->reservationData['user'] = $user->toArray();
                    $event->reservationData['book'] = $book->toArray();
                }

                $librarian->notify(new ReservationNotification($event->reservationData, $event->actionType));
            } catch (Exception $notificationException) {
                Log::error('Error sending reservation notification: ' . $notificationException->getMessage());
            }
        }

        Log::info('Updated Reservation Data:', $event->reservationData);
    }
}
