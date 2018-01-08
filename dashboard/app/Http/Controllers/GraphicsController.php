<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use ZabbixGraph;
use Validator;
use Illuminate\Http\Request;

/**
 * @property \Becker\Zabbix\ZabbixApi zabbix
 */
class GraphicsController extends Controller
{
    public function __construct()
    {
        $this->zabbix = app('zabbix');
    }


    public function index(Request $request)
    {
        $data = $this->zabbix->userGet([
            'output' => ['alias'],
            'preservekeys' => true
        ]);
        //dd($data);
        return view('graphics',['data' => $data]);

        /*$output = [];
        $output['errors'] = [];

        if(!isset($request->name)){
            $output['errors'][] = 'User not set';
            return view('graphics',['data' => $output]);
        }

        $user_array = $this->zabbix->userGet([
            'output' => 'extend',
            'filter' => [
                'alias' => $request->name
            ]
        ]);

        if(empty($user_array)){
            $output['errors'][] = 'User not found';
            return view('graphics',['data' => $output]);
        }

        $screen_array = $this->zabbix->screenGet([
            'output' => 'extend',
            'selectScreenItems' => 'extend',
            'userids' => $user_array[0]->userid
        ]);

        //dd($user_array,$screen_array);

        foreach($screen_array as $screen){
            foreach ($screen->screenitems as $screenitem){
                if($screenitem->resourcetype == "0"){
                    //echo $screenitem->resourceid."<br/>";
                    $output['servers'][$screen->screenid]['name'] = $screen->name;
                    $output['servers'][$screen->screenid]['graphics'][$screenitem->resourceid] = $screenitem->resourceid;
                }
            }
        }
        //dd($output);

        return view('graphics',['data' => $output]);*/
    }

    /**
     * @param Request $request
     */
    public function getScreens(Request $request){

        $screen_array = $this->zabbix->screenGet([
            'output' => ['name'],
            //'preservekeys' => true,
            'selectScreenItems' => ['resourcetype','resourceid'],
            'userids' => $request->userid
        ]);
        $screens_output = [];
        foreach($screen_array as $screen){
            $graphs = "";
            foreach ($screen->screenitems as $screenitem){
                if($screenitem->resourcetype == "0"){
                    if($graphs){
                        $graphs .= "_";
                    }
                    $graphs .= $screenitem->resourceid;
                }
            }
            if($graphs){
                $screens_output[] = [
                    'name' => $screen->name,
                    'graphs' => $graphs
                ];
            }
        }

        echo json_encode($screens_output);
    }

    public function getGraphics(Request $request){
        $graphs = explode("_", $request->input('graphs'));

        $data = $this->zabbix->graphGet([
            'output' => ['graphid','name','width','height'],
            'graphids' => $graphs
        ]);

        //dd($data);

        return view('graphic_ajax_list',['data' => $data]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getGraphImg(Request $request){
        $graph = ZabbixGraph::startTime(Carbon::now()->subDay())
            ->width($request->input('width', 800))
            ->height($request->input('height', 200))
            ->find($request->input('graph_id'));

        return response($graph)
            ->header('Content-Type', 'image/png');
    }
}
