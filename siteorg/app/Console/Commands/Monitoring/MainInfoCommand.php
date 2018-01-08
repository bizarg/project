<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\MainInfoMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MainInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:main';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'main monitor';

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
        Log::info('MainInfoCommand');
        $sites = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('main_info', 'sites.id', '=', 'main_info.site_id', 'left outer')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm')
            ->where(function ($query) {
                $query->whereNull('main_info.id')
                    ->orWhereRaw('TIMESTAMPDIFF(hour, `main_info`.`updated_at`,now()  ) >=  '. SiteManager::getMonitor(InfoType::main_info)['period']
                    );
            })
            ->orderBy('sites.id')
//            ->limit(10)
            ->get();

 
        foreach ($sites as $site) {
            dispatch(new MainInfoMonitor($site));
        }
    }
}
