<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationNotification extends Notification
{
    use Queueable;

    /**
     * The reservation details.
     *
     * @var array
     */
    protected $reservationData;

    /**
     * The type of action (created, updated, removed).
     *
     * @var string
     */
    protected $actionType;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $reservationData, string $actionType)
    {
        $this->reservationData = $reservationData;
        $this->actionType = $actionType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = ucfirst($this->actionType) . ' Reservation';

        return (new MailMessage)
            ->subject($subject)
            ->view(
                'emails.reservation',
                [
                    'reservationData' => $this->reservationData,
                    'actionType' => $this->actionType,
                    'user' => $this->reservationData['user'] ?? null,
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'action_type' => $this->actionType,
            'reservation_id' => $this->reservationData['id'],
            'user_name' => $this->reservationData['user']['name'] ?? null,
            'book_title' => $this->reservationData['book']['title'] ?? null,
            'reservation_date' => $this->reservationData['reservation_date'],
            'is_active' => $this->reservationData['is_active'],
        ];
    }
}
