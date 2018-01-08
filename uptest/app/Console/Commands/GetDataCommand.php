<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agents:data {from} {to}';

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
        $fromId = $this->argument('from');
        $toId = $this->argument('to');
        $fomDate = Carbon::now()->subMonth();
        DB::enableQueryLog();
        DB::connection('pgsql')->enableQueryLog();

        //$data = DB::connection('pgsql')->select('SELECT * FROM  data WHERE agent_id = ? and rel = ? ORDER BY id ASC LIMIT 100', [$fromId, $toId]);
        //$data = DB::connection('pgsql')->select('SELECT * FROM  data WHERE agent_id = ? and rel = ? ORDER BY id ASC LIMIT 100', [$fromId, $toId]);
//        $data = DB::connection('pgsql')
//            ->select(
//                'SELECT * FROM  data WHERE agent_id = :fromId and rel = :toId and created_at > :fomDate  ORDER BY id ASC  ',
//                compact('fromId', 'toId', 'fomDate')
//            );
        //$data = DB::connection('pgsql')->select('SELECT * FROM  data WHERE agent_id = 19 and rel = 4 ORDER BY id ASC LIMIT 100');


        $data = DB::connection('pgsql')
            ->select(
                'SELECT speed, created_at   FROM  data WHERE agent_id = :fromId and rel = :toId and created_at > :fomDate  ORDER BY id ASC  ',
                [
                    'fromId' => $fromId,
                    'toId' => $toId,
                    'fomDate' => $fomDate
                ]

            );

        //dd(DB::connection('pgsql')->getQueryLog());
        Log::info($data );
        dd();
        foreach ($data as $obj){
            print_r($obj);
            sleep(1);
        }
        //dd($data);

    }
}
