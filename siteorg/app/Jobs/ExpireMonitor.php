<?php

namespace App\Jobs;

use App\Scanners\ExpireScanner;
use App\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class ExpireMonitor
 * @package App\Jobs
 */
class ExpireMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $site;
    public $tries = 1;

    /**
     * ExpireMonitor constructor.
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->queue = 'expire_queue';

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ExpireScanner::expire($this->site, true);

    }
}
