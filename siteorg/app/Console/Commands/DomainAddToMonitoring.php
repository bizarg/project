<?php

namespace App\Console\Commands;

 use App\Facades\SiteManager;
 use App\UserSite;
use Illuminate\Console\Command;

class DomainAddToMonitoring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:monitoring {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add domain to monitoring';



 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( )
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


        $site = SiteManager::find_or_create($this->argument('domain'));
        if (!empty($site)) {
            $usersite = UserSite::where('site_id', $site->id)
                ->where('status', 'enabled')
                ->where('confirm', '!=', 'not_confirm')
                ->first();

            if (empty($usersite)) {
                dd("site not have user");
            }
            SiteManager::add_to_monitring($site);
        }

    }
}
