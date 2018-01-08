<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use Mail;

class emailAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email Admin about limit time task';

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
        $dates = Task::all();

        $day = time() + 60 * 60 * 24;
        $week = time() + 60 * 60 * 24 * 7;

        foreach($dates as $date) {

            if ($date->date < $day) {
                if (!$date->msg_day) {
                    Mail::queue('emails.deadline', array('date' => $date, 'day' => 1), function ($message) {
                        $message->to('spfhu@rambler.ru')->subject('Deadline');
                    });
                    $date->msg_day = 1;
                    $date->save();
                }
            }

            if ($date->date < $week) {
                if (!$date->msg_week) {
                    Mail::queue('emails.deadline', array('date' => $date, 'day' => 7), function ($message) {
                        $message->to('spfhu@rambler.ru')->subject('Deadline');
                    });
                    $date->msg_week = 1;
                    $date->save();
                }
            }
        }
    }
}
