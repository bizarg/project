<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class DomainAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:add {domain}';

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


        $request = Request::create(url('domain/add'), 'POST', []);


        $request->data = [
            'domain' => $this->argument('domain'),
         ];
        $request->user = User::find(1);
        $resp = app()->call('App\Http\Controllers\ApiController@add_domain_to_user', ['request' => $request]);
        dd($resp);
    }
}
