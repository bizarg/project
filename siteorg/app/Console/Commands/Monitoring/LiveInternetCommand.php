<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\LiveInterneMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LiveInternetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:li';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'liveinternet  monitor';

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
        Log::info('LiveInternetCommand');
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereRaw('(SELECT count(*) FROM `liveinternet` WHERE `liveinternet`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF
                            (
                                hour, 
                                (
                                    SELECT `liveinternet`.`updated_at` 
                                    FROM `liveinternet` 
                                    WHERE `liveinternet`.`site_id` = `sites`.`id` 
                                    order by `liveinternet`.`updated_at` desc 
                                    limit 1
                                 ),
                                 now()  
                            ) >=  '. SiteManager::getMonitor(InfoType::liveinternet)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(10)
            ->get();

        foreach ($sites as $site) {
            dispatch(new LiveInterneMonitor($site));
        }
    }
}
