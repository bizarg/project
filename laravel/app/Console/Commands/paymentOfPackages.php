<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain;
use Mail;
use App\Http\Payment\Biling;

class paymentOfPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly service fee';

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
        $domains = Domain::where('status_id', 2)->with('user', 'tariff')->get();

        foreach($domains as $domain){
            if($domain->begin_at < time()) {
                $user = $domain->user;
                $tariff = $domain->tariff;
                if($user->balance > $tariff->value){
                    $user->update(['balance' => $user->balance -= $tariff->value]);

                    $domain->update(['begin_at' => time() + 10]);

                    Mail::queue(
                        'emails.payed',
                        array(
                            'name' => $domain->name,
                            'tariff' => $tariff->value,
                            'date' => $domain->begin_at
                        ),
                        function ($message) use ($user){
                        $message->to($user->email)->subject('Payed');}
                    );
                } else {
                    $domain->update(['status_id' => Biling::INACTIVE]);
                    Mail::queue(
                        'emails.inactive',
                        array('name' => $domain->name),
                        function ($message) use ($user){
                            $message->to($user->email)->subject('Inactive');}
                    );
                }
            }
        }
    }
}
