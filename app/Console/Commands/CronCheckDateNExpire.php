<?php

namespace App\Console\Commands;

use App\User;
use App\Vehicle;
use Illuminate\Console\Command;

class CronCheckDateNExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:checkDateNExpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle() {

        // check driver
        $collection = User::
                        where('type', User::DRIVER)
                        ->whereDate('expire_date', '<', date('Y-m-d'))
                        ->update(['is_verified' => 0]);

        // vehicles

        $collection = Vehicle::where(function($q){
            $q->orWhereDate('expire_date', '<', date('Y-m-d'));
            $q->orWhereDate('fitness_validity', '<', date('Y-m-d'));
            $q->orWhereDate('insurance_validity', '<', date('Y-m-d'));
        })->update(['is_verified' => 0]);

    }
}
