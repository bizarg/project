<?php

namespace App\Jobs;

use App\Scanners\FBScanner;
use App\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FBLikesMonitor implements ShouldQueue
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
        $this->queue = 'fblikes_queue';

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        FBScanner::fbLiks($this->site, true);
    }


}
