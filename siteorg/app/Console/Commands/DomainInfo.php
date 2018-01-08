<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class DomainInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:info {domain} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Domain info';

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


        $request = Request::create(url('domain/info'), 'POST', []);


        $request->data = [
            'domain' => $this->argument('domain'),
            'type' => $this->argument('type'),
            'update' => true,
        ];
        $request->user = User::find(1);
        $resp = app()->call('App\Http\Controllers\ApiController@get_domain_info', ['request' => $request]);
        dd($resp);
    }
}
