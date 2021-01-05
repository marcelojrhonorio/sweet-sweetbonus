<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class DispatchConfirmationJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'confirmation:dispatch {queue} {job} {email} {fakePass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $customer = Customer::where('email', $this->argument('email'))->first();

        if (empty($customer)) {
            return;
        }

        $class = '\\App\\Jobs\\' . $this->argument('job');

        Queue::pushOn(
            $this->argument('queue'),
            new $class($customer, $this->argument('fakePass'))
        );
    }
}
