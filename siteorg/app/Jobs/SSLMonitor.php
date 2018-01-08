<?php

namespace App\Jobs;

use App\Scanners\SSLScanner;
use App\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SSLMonitor implements ShouldQueue
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
        $this->queue = 'ssl_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SSLScanner::sslParams($this->site, true);
    }

}
