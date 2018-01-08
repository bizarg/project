<?php

namespace App\Jobs;

use App\Facades\NotificationManager;
use App\Scanners\StatusScanner;
use App\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StatusMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $site;
    public $tries = 3;
 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->queue = 'status_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        StatusScanner::speedParams($this->site, true);
    }

}
