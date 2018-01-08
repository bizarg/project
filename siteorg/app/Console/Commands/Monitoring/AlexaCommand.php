<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\AlexaMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AlexaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:alexa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'alexa monitor';

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
        Log::info('AlexaCommand');
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereRaw('(SELECT count(*) FROM `alexa_ranks` WHERE `alexa_ranks`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF
                    (
                        hour, 
                        (
                            SELECT `alexa_ranks`.`updated_at` FROM `alexa_ranks` 
                                    WHERE `alexa_ranks`.`site_id` = `sites`.`id`
                                    order by `alexa_ranks`.`updated_at` desc 
                                    limit 1
                        ),
                        now()  
                    ) >= ' . SiteManager::getMonitor(InfoType::alexa)['period']
                    );
            })
            ->orderBy('sites.id')
            //->limit(10)
            ->get();
        foreach ($sites as $site) {
            dispatch(new AlexaMonitor($site));
        }
    }
}
