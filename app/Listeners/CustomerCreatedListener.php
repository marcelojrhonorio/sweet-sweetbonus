<?php

namespace App\Listeners;

use App\Jobs\CustomerCreatedJob;
use Illuminate\Support\Facades\Log;
use App\Events\CustomerCreatedEvent;
use App\Jobs\RelationshipStepOneJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     *
     * @param  CustomerCreatedEvent  $event
     */
    public function handle(CustomerCreatedEvent $event)
    {
        /**
         * Dispatch "Sweet Bonus: Confirme o seu e-mail".
         */
        CustomerCreatedJob::dispatch($event->customer, $event->password);
    }
}
