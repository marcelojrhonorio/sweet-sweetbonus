<?php

namespace App\Listeners;

use App\Traits\SweetStaticApiTrait;
use App\Events\CarInsuranceCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IsCarInsuranceLead
{

    use SweetStaticApiTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CarInsuranceCreated $event)
    {
        $response = self::executeSweetApi(
            'GET',
            env('STORE_URL') . '/researches/insurance/lead-dispatch?customer_id=' . $event->customer_id,
            []
        ); 
    }
}
