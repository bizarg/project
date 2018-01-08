<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\ExpireMonitor;
use App\Jobs\SSLMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DomainExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:expire {--r}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'domain expire monitor';

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
        Log::info('domain expire');

        $q = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('domain_expires', 'sites.id', '=', 'domain_expires.site_id', 'left outer')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm');
        if (!$this->option('r')) {
            $q->where(function ($query) {
                $query->whereNull('domain_expires.id')
                    ->orWhereRaw('TIMESTAMPDIFF(hour, `domain_expires`.`updated_at`,now()  ) >= ' . SiteManager::getMonitor(InfoType::expire)['period'])
                    ->orWhereNull('domain_expires.expired');
            });
        }

        $q->orderBy('sites.id');
        $sites = $q->get();
        foreach ($sites as $site) {
            dispatch(new ExpireMonitor($site));
        }
    }
}
