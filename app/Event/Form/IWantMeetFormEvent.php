<?php

namespace App\Event\Form;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IWantMeetFormEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?array $user;
    /**
     * Create a new event instance.
     * Создайте новый экземпляр события.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
