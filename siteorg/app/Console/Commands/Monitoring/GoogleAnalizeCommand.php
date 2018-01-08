<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\GoogleAnalizeMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoogleAnalizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:google_analize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'google analize monitor';

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
        Log::info('GoogleAnalizeCommand');
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('google_analize', 'sites.id', '=', 'google_analize.site_id', 'left outer')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereNull('google_analize.id')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF(hour, `google_analize`.`updated_at`,now()  ) 
                        >= ' . SiteManager::getMonitor(InfoType::google_analize)['period']
                    );
            })
            ->orderBy('sites.id')
            //->limit(10)
            ->get();

        foreach ($sites as $site) {
            dispatch(new GoogleAnalizeMonitor($site));
        }
    }
}
