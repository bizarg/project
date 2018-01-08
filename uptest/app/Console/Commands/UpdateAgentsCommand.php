<?php

namespace App\Console\Commands;

use App\Node;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateAgentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agents:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update agetns from gosys';

    private $coutries;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function loadCountries()
    {

        $jsonCoutries = Storage::get('countries.json');

        $this->coutries = json_decode($jsonCoutries);
    }

    private function findCoutry($aiso)
    {

        $find = array_filter($this->coutries, function ($coutry) use ($aiso) {

            return $coutry->{'alpha-2'} == $aiso;
        });


        if (empty($find))
            return false;
        return array_shift($find);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $this->loadCountries();
        $agents = DB::connection('pgsql')->select('SELECT * FROM  agents ORDER BY id ASC');
        foreach ($agents as $agent) {
            $this->info("Update {$agent->name}");

            $location = DB::connection('pgsql')->select('SELECT * FROM locations where id = ? limit 1', [$agent->location_id]);
            $node = Node::where('gs_id', $agent->id)->first();
            if (is_null($node)) {
                $node = new Node();
                $node->gs_id = $agent->id;
            }
            $node->name = $agent->name;
            $node->ip = $agent->ip;
            $node->port = 8585;

            $node->aiso = $location[0]->aiso;
            $node->dc = $agent->dc;
            $node->city = $agent->city;
            if ($agent->status == 'active') {
                $node->status = 'active';
            } else {
                $node->status = 'inactive';
            }
            $country = $this->findCoutry($node->aiso);


            if ($country !== false) {
                $node->country = $country->name;
            } else {
                $node->country = $node->aiso;
            }
            $node->save();

        }

    }
}
