<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\StatusMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Log;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'status monitor';

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
        Log::info('StatusCommand');

        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereRaw('(SELECT count(*) FROM `statuses` WHERE `statuses`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF
                        (
                            hour,
                            (
                                SELECT `statuses`.`updated_at`
                                FROM `statuses`
                                WHERE
                                `statuses`.`site_id` = `sites`.`id`
                                order by `statuses`.`updated_at` desc
                                limit 1
                            ),
                            now()
                        ) >=  ' . SiteManager::getMonitor(InfoType::status)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(10)
            ->get();
        Log::info('start status monitor. Scan '. count($sites));
        foreach ($sites as $site) {
            dispatch(new StatusMonitor($site));
        }
    }
}
