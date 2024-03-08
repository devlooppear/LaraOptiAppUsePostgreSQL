<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationEvent
{
    use Dispatchable, SerializesModels;

    /**
     * The reservation data.
     *
     * @var array
     */
    public $reservationData;

    /**
     * The action type (created, updated, removed).
     *
     * @var string
     */
    public $actionType;

    /**
     * Create a new event instance.
     */
    public function __construct(array $reservationData, string $actionType)
    {
        $this->reservationData = $reservationData;
        $this->actionType = $actionType;
    }
}
