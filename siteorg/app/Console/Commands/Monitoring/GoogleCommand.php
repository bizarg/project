<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\GoogleMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoogleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:google {--r}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'google monitor';

    /**
     * Create a new command instance.
     *
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
        Log::info('GoogleCommand');
        $r = $this->option('r');
        DB::connection()->enableQueryLog();
        $q = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm');
        if (!$r) {
            $q->where(function ($query) use ($r) {
                $query->whereRaw('(SELECT count(*) FROM `google_index` WHERE `google_index`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF
                        (
                            hour, 
                                (
                                SELECT `google_index`.`updated_at` 
                                FROM `google_index` 
                                WHERE 
                                `google_index`.`site_id` = `sites`.`id` 
                                order by `google_index`.`updated_at` desc 
                                limit 1
                                ),
                             now()  
                        ) >= ' . SiteManager::getMonitor(InfoType::google_index)['period']);

            });
        }
        $q->orderBy('sites.id');
        //->limit(10)

        $sites = $q->get();
        foreach ($sites as $site) {
            dispatch(new GoogleMonitor($site));
        }
    }
}
