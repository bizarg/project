<?php

namespace App\Console\Commands;

use App\Message;
use App\Notifications\DomainMessage;
use App\User;
use Illuminate\Console\Command;

class MessageSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:sender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add messages to queue';

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
        $messages = Message::where('status', 'show')->where('sended', 0)->get();
        foreach ($messages as $message) {
            $site = $message->site()->first();
            $user = User::join('user_sites', 'user_sites.user_id', '=', 'users.id')
                ->where('user_sites.status', 'enabled')
                ->where('user_sites.confirm', '!=', 'not_confirm')
                ->where('user_sites.site_id', $site->id)
                ->first();
            //dd($user);
              $user->notify(new DomainMessage($message));

        }
    }
}
