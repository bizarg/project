<?php

namespace App\Jobs;

use App\Scanners\LiveInternetScanner;
use App\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LiveInterneMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $site;
    public $tries = 1;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->queue = 'liveinterne_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        LiveInternetScanner::liveInternetParams($this->site, true);
    }

}
