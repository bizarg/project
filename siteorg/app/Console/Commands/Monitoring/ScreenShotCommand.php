<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\ScreenShotMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScreenShotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:screenshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'screenshot monitor';

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
        Log::info('ScreenShotCommand');

        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereRaw('(SELECT count(*) FROM `screenshots` WHERE `screenshots`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw
                    (
                        'TIMESTAMPDIFF
                        (
                            hour, 
                            (
                                SELECT `screenshots`.`updated_at` 
                                FROM `screenshots` 
                                WHERE 
                                `screenshots`.`site_id` = `sites`.`id` 
                                order by `screenshots`.`updated_at` desc 
                                limit 1
                             ),
                             now()  
                        ) >=  ' . SiteManager::getMonitor(InfoType::screenshot)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(10)
            ->get();
        foreach ($sites as $site) {
            dispatch(new ScreenShotMonitor($site));
        }
    }
}
