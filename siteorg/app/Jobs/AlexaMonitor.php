<?php

namespace App\Jobs;

use App\Facades\NotificationManager;
use App\Facades\SiteManager;
use App\Scanners\AlexaScanner;
use App\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AlexaMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 1;
    protected $site;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->queue = 'alexa_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        AlexaScanner::alexaRankParams($this->site, true);

    }
}
