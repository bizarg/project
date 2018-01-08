<?php

namespace App\Console\Commands;

use App\Facades\MessagesManager;
use App\Site;
use Illuminate\Console\Command;

class AddMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:add {domain} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add message to domain. message mast be name from error class.';

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
 
        $site = Site::where('domain', $this->argument('domain'))->first();
        if (!isset($site)) {
            dd('domain not found');
        }


        if (!defined('App\Types\Error::' . $this->argument('message'))) {
            dd('message not exist');
        }
 

        MessagesManager::addMessage($site, $this->argument('message'));

    }
}
