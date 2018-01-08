<?php

namespace App\Console\Commands;

use App\Facades\SiteManager;
use App\User;
use App\UserSite;
use Faker\Provider\Uuid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $users = DB::select('SELECT `st_users`.* FROM `st_users` WHERE `id` not in (1,2, 5, 68, 69, 36 , 3, 76, 83, 11, 48, 884, 145) and ( SELECT count(*) FROM `st_domains_users` WHERE `st_domains_users`.`user_id` = `st_users`.`id` AND `st_domains_users`.`confirmtype` != 0 ) > 0');
        $id = 4;
        $siteId = 200;
        
        foreach ($users as $ouser) {
           // dd($ouser);
            $id++;
            $user = new User();
            $user->id = $id;
            $user->name = $ouser->name;
            $user->email = $ouser->email;
            $user->password = bcrypt('ocrl7t' . $id);
            $user->api_key = Uuid::uuid();
            $user->sex = $ouser->sex ? 'female' : 'male';
              $user->save();

            $sql = 'SELECT * FROM `st_domains_users` WHERE `user_id`= ? and `confirmtype` != ?';
            $uds = DB::select($sql, [$ouser->id, 0]);
            foreach ($uds as $ud) {
                $sql = 'SELECT * FROM `st_domains` where `id` = ?';
                $domains = DB::select($sql, [$ud->domain_id, 0]);

                foreach ($domains as $domain) {
                    $domain = $domain->site;
                    $siteId++;
                    $this->info($user->name . ' -- ' . $domain);
                    $site = SiteManager::find_or_create($domain);
                    if (empty($site))
                        continue;
                    $userSite = UserSite::where('site_id', $site->id)
                        ->where('status', 'enabled')
                        ->where('confirm', '!=', 'not_confirm')
                        ->first();

                    if (!empty($userSite)) {
                        $userSite->delete();
                    }

                    $userSite = new UserSite();
                    $userSite->user_id = $user->id;
                    $userSite->site_id = $site->id;
                    $userSite->notify_level = 1;
                    $userSite->status = 'enabled';
                    $userSite->confirm = 'file';
                    $userSite->save();
                    $this->info('end add' . $domain);
                }


                //dd($domains);
            }
            //dd($ud);
        }
    }
}
