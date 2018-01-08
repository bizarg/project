<?php

namespace App\Jobs;

use App\Managers\Error\YandexProxiTimeOutException;
use App\Scanners\GoogleScanner;
use App\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GoogleMonitor implements ShouldQueue
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
        $this->queue = 'google_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            GoogleScanner::googleIndexParams($this->site, true);
        } catch (YandexProxiTimeOutException $ex) {
            dispatch((new GoogleMonitor($this->site))->delay(Carbon::now()->addMinutes(15)));
        }
    }

}
