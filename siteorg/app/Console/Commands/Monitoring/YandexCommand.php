<?php

namespace App\Console\Commands\Monitoring;

use App\Facades\SiteManager;
use App\Jobs\YandexMonitor;
use App\Site;
use App\Types\InfoType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class YandexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:yandex  {--r}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'yandex monitor';

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
        Log::info('YandexCommand');
        $r = $this->option('r');

        $q = Site::select('sites.*')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.status', 'enabled')
            ->where('user_sites.confirm', '!=', 'not_confirm');
        if (!$r) {
            $q->where(function ($query) {
                $query->whereRaw('(SELECT count(*) FROM `yandex_index` WHERE `yandex_index`.`site_id` = `sites`.`id`) = 0')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF
                            (
                                hour,
                                (
                                    SELECT `yandex_index`.`updated_at`
                                    FROM `yandex_index`
                                    WHERE
                                    `yandex_index`.`site_id` = `sites`.`id`
                                    order by `yandex_index`.`updated_at` desc
                                    limit 1
                                ),
                                now()
                            ) >=  ' . SiteManager::getMonitor(InfoType::yandex_index)['period']
                    );
            });
        }
        $q->orderBy('sites.id');
//            ->limit(10)
        $sites = $q->get();

        foreach ($sites as $site) {
            dispatch(new YandexMonitor($site));
        }
    }
}
