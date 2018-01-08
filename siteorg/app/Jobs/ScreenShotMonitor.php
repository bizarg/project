<?php

namespace App\Jobs;

use App\Scanners\ScreenShotScanner;
use App\ScreenShot;
use App\Site;
use App\Types\Error;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ScreenShotMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 1;

    protected $site;


    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->queue = 'screenshot_queue';
    }

    public function handle()
    {
        ScreenShotScanner::screenParams($this->site, true);
    }

}
