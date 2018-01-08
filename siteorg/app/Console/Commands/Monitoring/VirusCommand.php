<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\VirusesMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VirusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:virus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'viruses monitor';

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
        Log::info('VirusCommand');

        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('viruses', 'sites.id', '=', 'viruses.site_id', 'left outer')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereNull('viruses.id')
                    ->orWhereRaw('TIMESTAMPDIFF(hour, `viruses`.`updated_at`,now()  ) >=  ' . SiteManager::getMonitor(InfoType::virus)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(10)
            ->get();
        foreach ($sites as $site) {
            dispatch(new VirusesMonitor($site));
        }
    }
}
