<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\FBLikesMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FBLikesCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:fblikes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fb monitor';

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
        Log::info('FBLikesCommand');
        $monitor = SiteManager::getMonitor(InfoType::fb_likes);
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) use ($monitor) {
                $query->whereRaw('(SELECT count(*) FROM `fb` WHERE `fb`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw('
                    TIMESTAMPDIFF
                    (
                        hour, 
                        (
                            SELECT `fb`.`updated_at` FROM `fb` 
                            WHERE `fb`.`site_id` = `sites`.`id` 
                            order by `fb`.`updated_at` desc 
                            limit 1
                        ),
                        now()  
                    ) >= ' . $monitor['period']);
            })
            ->orderBy('sites.id')
            ->get();

        foreach ($sites as $site) {
            dispatch(new FBLikesMonitor($site));
        }
    }
}
