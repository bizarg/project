<?php

namespace App\Jobs;

use App\Scanners\VirusesScanner;
use App\Virus;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VirusResultMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $virus;
    public $tries = 1;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Virus $virus)
    {
        $this->virus = $virus;
        $this->queue = 'viruses_queue';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        VirusesScanner::getVirusScanResult($this->virus);
    }

}
