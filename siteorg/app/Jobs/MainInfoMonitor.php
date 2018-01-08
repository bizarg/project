<?php

namespace App\Jobs;

use App\Facades\NotificationManager;
use App\Notification;
use App\Scanners\MainScanner;
use App\Site;
use App\Types\Error;
use App\Types\Level;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MainInfoMonitor implements ShouldQueue
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
        $this->queue = 'maininfo_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dispatch((new MainInfoMonitor($this->site)));
    }

}
