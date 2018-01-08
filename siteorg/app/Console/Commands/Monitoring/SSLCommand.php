<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\SSLMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SSLCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:ssl {--r}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ssl monitor';

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
        Log::info('SSLCommand');

        $q = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('ssl', 'sites.id', '=', 'ssl.site_id', 'left outer')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm');
        if (!$this->option('r')) {
            $q->where(function ($query) {
                $query->whereNull('ssl.id')
                    ->orWhereRaw('TIMESTAMPDIFF(hour, `ssl`.`updated_at`,now()  ) >= ' . SiteManager::getMonitor(InfoType::ssl)['period']
                    );
            });
        }

        $q->orderBy('sites.id');
        $sites = $q->get();
        foreach ($sites as $site) {
            dispatch(new SSLMonitor($site));
        }
    }
}
