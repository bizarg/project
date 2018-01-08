<?php

namespace App\Console\Commands;

use App\Jobs\CheackSite;
use App\Site;
use Illuminate\Console\Command;

class Monitoring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add check sites to queue';

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
        $sites = Site::where('status', 'active')->get();
 
        foreach ($sites as $site) {
            dispatch(new CheackSite($site));
        }


    }
}
