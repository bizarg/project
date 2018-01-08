<?php

namespace App\Console\Commands;

 use App\Facades\SiteManager;
 use App\User;
use App\UserSite;
use Illuminate\Console\Command;

class DomainAddUser extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:user {user_id} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add domains to user';

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

        $domains = explode(',', $this->argument('domain'));
        $user = User::find($this->argument('user_id'));
        $this->info(count($domains));
        foreach ($domains as $domain) {
            $this->info($domain);
            $site = SiteManager::find_or_create($domain);
            if (empty($site))
                continue;
            $usersite = UserSite::where('site_id', $site->id)
                ->where('status', 'enabled')
                ->where('confirm', '!=', 'not_confirm')
                ->first();

            if (!empty($usersite)) {
                $usersite->delete();
            }

            $usersite = new UserSite();
            $usersite->user_id = $user->id;
            $usersite->site_id = $site->id;
            $usersite->notify_level = 1;
            $usersite->status = 'enabled';
            $usersite->confirm = 'file';
            $usersite->save();
            SiteManager::add_to_monitring($site);
            $this->info('end add' . $domain);
        }

    }
}
