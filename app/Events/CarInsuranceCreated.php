<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CarInsuranceCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($customer_id)
    {
        $this->customer_id = $customer_id;
    }

}
