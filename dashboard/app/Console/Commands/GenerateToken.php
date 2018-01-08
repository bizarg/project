<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:token {email} {amhost_id} {amhost_login}';

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
        $params = [
            'amhost_id' => $this->argument('amhost_id'),
            'amhost_login' => $this->argument('amhost_login'),
            'email' => $this->argument('email'),
        ];
        krsort($params);
        $sing = md5(implode($params) . 'ee95a16d763ab0d26ee62c53056df928');
        $params['sing'] = $sing;
        $request = Request::create(url('generate/token'), 'POST', $params);
        $resp = app()->call('App\Http\Controllers\Auth\PublicLoginController@generate_token', ['request' => $request]);
        $obj = json_decode($resp->content());
        if ($obj->error !== 0) {
            dd($obj);
        } else {
            echo env('APP_URL') . '/auth?token=' . $obj->data->login_token;
        }
         
    }
}
