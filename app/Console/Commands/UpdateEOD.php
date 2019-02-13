<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\EndOfDayData;
use Carbon\Carbon;

class UpdateEOD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateeod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update daily end of day data';

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
        // 260099 entry
        $today = Carbon::today();
        $return = EndOfDayData::storeEOD2DB($today);

        echo $return;
    }
}
