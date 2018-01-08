<?php

namespace App\Jobs;

use App\Info;
use App\Site;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheackSite extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $node = $this->site->node;

        //http://localhost:8080/api?domain=http://seria-z.net/country/turtsiya
        $url = 'http://' . $node->ip . ':' . $node->port . '/api?domain=' . $this->site->url;

        $objponse = @file_get_contents($url);
        //TODO сделать оповещение если нода не работает или не валидный ответ
        if ($objponse !== false) {
            $obj = json_decode($objponse);
            var_dump($obj);
            if (!is_null($obj)) {
                $info = new Info();
                $info->site_id = $this->site->id;
                $info->node_id = $node->id;
                if (empty($obj->error)) {
                    $info->speed_bps = $obj->sBps;
                    $info->size = $obj->traffBytes;
                    $info->ip = $obj->ip;
                    $info->time = $obj->time;
                    $info->code = $obj->responseCode;
                    $info->message = $obj->responseMessage;
                } else {
                    $info->error = $obj->error;
                }
                $info->save();
            }

        }

    }
}
