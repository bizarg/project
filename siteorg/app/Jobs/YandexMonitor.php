<?php

namespace App\Jobs;

use App\Managers\Error\YandexProxiTimeOutException;
use App\Scanners\YandexScanner;
use App\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class YandexMonitor implements ShouldQueue
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
        $this->queue = 'yandex_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            YandexScanner::yndexIndexParams($this->site, true);
        } catch (YandexProxiTimeOutException $ex) {
            dispatch((new YandexMonitor($this->site))->delay(Carbon::now()->addMinutes(15)));
        }

    }


}
