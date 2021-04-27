<?php

namespace App\Console\Commands\Property;

use Illuminate\Console\Command;
use Modules\Property\Services\PropertyCronService;

class Expiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify owner of listed property status';

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
     * @return int
     */
    public function handle(): int
    {
        PropertyCronService::validateActiveProperties();
        PropertyCronService::checkInactiveProperties();
        return 0;
    }
}
