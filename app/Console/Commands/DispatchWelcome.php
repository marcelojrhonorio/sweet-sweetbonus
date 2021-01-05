<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\RelationshipStepOneJob;
use Illuminate\Support\Facades\Queue;

class DispatchWelcome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'welcome:dispatch {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch relationship step one job';

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

        $job = new RelationshipStepOneJob($customer);

        Queue::pushOn('sweetbonus_relationship', $job);
    }
}
