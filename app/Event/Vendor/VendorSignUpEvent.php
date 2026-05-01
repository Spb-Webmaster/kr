<?php

namespace App\Event\Vendor;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VendorSignUpEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly array $vendor)
    {
    }
}
