<?php

namespace App\Console;

use App\Console\Commands\AddMessage;
use App\Console\Commands\DomainAdd;
use App\Console\Commands\DomainAddToMonitoring;
use App\Console\Commands\DomainAddUser;
use App\Console\Commands\DomainInfo;
use App\Console\Commands\MessageSender;
use App\Console\Commands\MigrateOld;
use App\Console\Commands\Monitoring\AlexaCommand;
use App\Console\Commands\Monitoring\DomainExpireCommand;
use App\Console\Commands\Monitoring\FBLikesCommand;
use App\Console\Commands\Monitoring\GoogleAnalizeCommand;
use App\Console\Commands\Monitoring\GoogleCommand;
use App\Console\Commands\Monitoring\GoogleParamsCommand;
use App\Console\Commands\Monitoring\LiveInternetCommand;
use App\Console\Commands\Monitoring\MainInfoCommand;
use App\Console\Commands\Monitoring\RosKomNadzorCommand;
use App\Console\Commands\Monitoring\RosNadzorCommand;
use App\Console\Commands\Monitoring\ScreenShotCommand;
use App\Console\Commands\Monitoring\SSLCommand;
use App\Console\Commands\Monitoring\StatusCommand;
use App\Console\Commands\Monitoring\VirusCommand;
use App\Console\Commands\Monitoring\VKLikesCommand;
use App\Console\Commands\Monitoring\YandexCommand;
use App\Console\Commands\Monitoring\YandexParamsCommand;
use App\Facades\SiteManager;
use App\Types\InfoType;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        DomainInfo::class,
        DomainAdd::class,

        //-------Monitors-----------//
        AlexaCommand::class,
        FBLikesCommand::class,
        GoogleAnalizeCommand::class,
        GoogleCommand::class,
        GoogleParamsCommand::class,
        LiveInternetCommand::class,
        MainInfoCommand::class,
        RosKomNadzorCommand::class,
        ScreenShotCommand::class,
        SSLCommand::class,
        StatusCommand::class,
        VirusCommand::class,
        VKLikesCommand::class,
        YandexCommand::class,
        YandexParamsCommand::class,
        AddMessage::class,
        MessageSender::class,
        DomainAddToMonitoring::class,
        DomainAddUser::class,
        DomainExpireCommand::class,


        MigrateOld::class

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('monitor:status')->cron('0 */' . SiteManager::getMonitor(InfoType::status)['period'] . ' * * * *');
        $schedule->command('monitor:alexa')->cron('0 */' . SiteManager::getMonitor(InfoType::alexa)['period'] . ' * * * *');
        $schedule->command('monitor:fblikes')->cron('0 */' . SiteManager::getMonitor(InfoType::fb_likes)['period'] . ' * * * *');
        $schedule->command('monitor:google_analize')->cron('0 */' . SiteManager::getMonitor(InfoType::google_analize)['period'] . ' * * * *');
        $schedule->command('monitor:google')->cron('0 */' . SiteManager::getMonitor(InfoType::google_index)['period'] . ' * * * *');
        $schedule->command('monitor:google_params')->cron('0 */' . SiteManager::getMonitor(InfoType::google_pr)['period'] . ' * * * *');
        $schedule->command('monitor:li')->cron('0 */' . SiteManager::getMonitor(InfoType::liveinternet)['period'] . ' * * * *');
        $schedule->command('monitor:roskomnadzor')->cron('0 */' . SiteManager::getMonitor(InfoType::roskomnadzor)['period'] . ' * * * *');
        $schedule->command('monitor:screenshot')->cron('0 */' . SiteManager::getMonitor(InfoType::screenshot)['period'] . ' * * * *');
        $schedule->command('monitor:ssl')->cron('0 */' . SiteManager::getMonitor(InfoType::ssl)['period'] . ' * * * *');
        $schedule->command('monitor:virus')->cron('0 */' . SiteManager::getMonitor(InfoType::virus)['period'] . ' * * * *');
        $schedule->command('monitor:vklikes')->cron('0 */' . SiteManager::getMonitor(InfoType::vk_likes)['period'] . ' * * * *');
        $schedule->command('monitor:yandex')->cron('0 */' . SiteManager::getMonitor(InfoType::google_index)['period'] . ' * * * *');
        $schedule->command('monitor:yandex_params')->cron('0 */' . SiteManager::getMonitor(InfoType::yandex)['period'] . ' * * * *');

        $schedule->command('monitor:expire')->cron('0 */' . SiteManager::getMonitor(InfoType::expire)['period'] . ' * * * *');



    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
