<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\RosNadzorMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RosKomNadzorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:roskomnadzor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'roskomnadzor monitor';

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
        Log::info('RosKomNadzorCommand');
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('roskomnadzor', 'sites.id', '=', 'roskomnadzor.site_id', 'left outer')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereNull('roskomnadzor.id')
                    ->orWhereRaw('TIMESTAMPDIFF(hour, `roskomnadzor`.`updated_at`,now()  ) >= '. SiteManager::getMonitor(InfoType::roskomnadzor)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(10)
            ->get();
        foreach ($sites as $site) {
            dispatch(new RosNadzorMonitor($site));
        }
    }
}
