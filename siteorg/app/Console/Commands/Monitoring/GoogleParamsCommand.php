<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\GoogleParamsMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoogleParamsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:google_params';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'google params monitor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('GoogleParamsCommand');
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereRaw('(SELECT count(*) FROM `google_pr` WHERE `google_pr`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF
                            (
                                hour, 
                                (
                                    SELECT `google_pr`.`updated_at` 
                                    FROM `google_pr` 
                                    WHERE 
                                    `google_pr`.`site_id` = `sites`.`id` 
                                    order by `google_pr`.`updated_at` desc 
                                    limit 1
                                ),
                                now()
                            ) >= ' . SiteManager::getMonitor(InfoType::google_pr)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(20)
            ->get();
        foreach ($sites as $site) {
            dispatch(new GoogleParamsMonitor($site));
        }
    }
}
