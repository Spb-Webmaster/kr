<?php

namespace App\Event\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignUpFormEvent
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
