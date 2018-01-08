<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Report;
use App\RequestTask;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class TaskController extends Controller
{


    public function log_writer(Request $request)
    {

        $task_id = $request->input('taskid');
        $action = $request->input('action');
        switch ($action) {
            case 'log':
                $log = $request->input('log');
                $reports = json_decode($log);

                foreach ($reports as $num => $report) {
                    if (Report::where('task_id', $report->task_id)->where('num', $num)->count() == 0) {
                        if ($report->users_send > 0 || $report->users_request > 0) {
                            $dbReport = new Report();
                            $dbReport->task_id = $report->task_id;
                            $dbReport->users_send = $report->users_send;
                            $dbReport->users_request = $report->users_request;
                            $dbReport->all_request = $report->all_request;
                            $dbReport->work_time = $report->work_time;
                            //$dbReport->speed_upload = $report->upload_speed;
                            $dbReport->speed_download = $report->download_speed;
                            //$dbReport->upload_time = $report->upload_time;
                            $dbReport->download_time = $report->download_time;
                            $dbReport->traff_download = $report->traff_download;
                            //$dbReport->traff_upload = $report->traff_upload;
                            $dbReport->intensity = $report->intensity;


                            $dbReport->codes_requests = json_encode($report->codes_requests);
                            $dbReport->num = $num;
                            $dbReport->save();
                        }
                    }
                }
                break;
            case 'end':
                $task = Task::find($task_id);
                $task->status = 'finished';
                $task->end = Carbon::now()->toDateTimeString();
                $task->save();
                break;


        }


    }

    public function task_detail($id)
    {
        $user = Auth::user();
        $task = Task::where('id', $id)->whereRaw('domain_id in (select  id from domains where user_id = ' . $user->id . ')')->firstOrFail();

        $request = new RequestTask();
        $request->action = 'status';
        $request->taskId = $id;

        try {
            $resp = $this->sendTask(json_encode($request));
            $task = Task::find($task->id);
            if ($task->status == 'inprogress') {
                if ($resp != 'work') {
                    $task->status = 'error';
                    $task->save();
                }
            }
        } catch (\Exception $e) {
            if ($task->status == 'inprogress') {
                $task->status = 'error';
                $task->save();
            }
        }

        $reports = Report::where('task_id', $task->id)->get();
        foreach ($reports as $report) {
            $report->codes_requests = json_decode($report->codes_requests, true);
        }
        if ($task->type == 'static') {
            return view('service.info_static', ['task' => $task, 'reports' => $reports]);
        } else {
            return view('service.info_dynamic', ['task' => $task, 'reports' => $reports]);
        }

    }


    public function tasks_all(Request $request)
    {

        $user = Auth::user();
        $rowBuilder = Task::select('tasks.*')->whereRaw('domain_id in (select  id from domains where user_id = ' . $user->id . ' )')->join('domains', 'domains.id', '=', 'tasks.domain_id');

        if ($request->input('type', false) !== false && $request->input('type') !== '') {
            $rowBuilder->where('tasks.type', $request->input('type'));
        }

        if ($request->input('status', false) !== false && $request->input('status') !== '') {
            $rowBuilder->where('tasks.status', [$request->input('status')]);
        }

        if ($request->input('search', false) !== false && $request->input('search') !== '') {
            $search = $request->input('search');
            $rowBuilder->where('domains.domain', 'like', "%$search%");
        }

        $tasks = $rowBuilder->orderBy('tasks.created_at', 'desc')->paginate(20);

        return view('service.job', ['tasks' => $tasks]);
    }

    public function new_task_form($id = null)
    {
        $user = Auth::user();
        $activeDomain = null;
        $domains = Domain::where('status', 'confirmed')->get();
        $types = ['static', 'dynamic'];
        //$types = ['static'];

        $periods = [10, 30, 60, 90, 120, 180, 300, 600];
        $wtimes = [1, 5, 10, 20, 30];

        if (isset($id)) {
            $activeDomain = Domain::find($id);
            if (!isset($activeDomain) || $activeDomain->user_id != $user->id) {
                $activeDomain = null;
            }
        }


        return view('service.task',
            ['types' => $types,
                'domains' => $domains,
                'active_domain' => $activeDomain,
                'periods' => $periods,
                'wtimes' => $wtimes,
            ]);
    }

    public function new_task_add(Request $request)
    {
        $user = Auth::user();


        if($user->role == 'user'){
            if($user->balance < 1){
                return redirect()->to('/balance')->with('error', 'На Вашем балансе не хватает средств');
            }
        }




        Validator::extend('user_dmain', function ($attribute, $value, $parameters, $validator) {
            $parse_url = @parse_url($value);
            $user_id = $parameters[1];
            if (isset($parse_url)) {
                return Domain::where('domain', $parse_url ['host'])->where('user_id', $user_id)->count() > 0;
            } else {
                return false;
            }


        }, 'Bad url');
        Validator::extend('valid_url', function ($attribute, $value, $parameters, $validator) {
            $headers = @get_headers($value);
            if (strpos($headers[0], '200')) {
                return true;
            } else {
                return false;
            }


        }, 'Invalid url');


        $intensityrule = 'required|integer|between:10,1000';
        $intensity_steprule = 'required_if:type,dynamic|integer|between:10,100';
        $queryrule = 'required|valid_url|user_dmain:user_id,' . $user->id . '|url|max:2048';
        if ($user->role == 'admin') {
            $intensityrule = 'required|integer';
            $intensity_steprule = 'required_if:type,dynamic|integer';
            $queryrule = 'required|valid_url|url|max:2048';
        }
        $v = Validator::make($request->all(), [
            //'domain' => 'required|domain_url|exists:domains,id,user_id,'.$user->id,
            'query' => $queryrule,
            'type' => 'required',
            'intensity' => $intensityrule,
            'intensity_step' => $intensity_steprule,
            'work_time' => 'required_if:type,static|integer',
            'wait_time' => 'required_if:type,dynamic|integer',

        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }


        $parse_url = @parse_url($request->input('query'));
        $domain = Domain::where('domain', $parse_url['host'])->first();

        $res_urls = [];
        $content = file_get_contents($request->input('query'));
        if ($request->input('css', false)) {
            $scripts = $this->get_css($content);
            $scripts = preg_grep('~^https?://(?:www\\.)?' . $parse_url['host'] . '.*$~is', $scripts, 0);
            $res_urls = array_merge($res_urls, $scripts);
        }
        if ($request->input('js', false)) {
            $scripts = $this->get_scripts($content);
            $scripts = preg_grep('~^https?://(?:www\\.)?' . $parse_url['host'] . '.*$~is', $scripts, 0);
            $res_urls = array_merge($res_urls, $scripts);
        }
        if ($request->input('img', false)) {
            $scripts = $this->get_images($content);
            $scripts = preg_grep('~^https?://(?:www\\.)?' . $parse_url['host'] . '.*$~is', $scripts, 0);
            $res_urls = array_merge($res_urls, $scripts);
        }

        $task = new Task();
        $task->domain_id = $domain->id;
        $task->type = $request->input('type');
        $task->intensity = $request->input('intensity');
        $task->intensity_step = $request->input('intensity_step', 0);
        $task->main_url = $request->input('query');
        $task->status = 'new';
        $task->css = $request->input('css', 0);
        $task->js = $request->input('js', 0);
        $task->img = $request->input('img', 0);
        $task->work_time = $request->input('work_time', 0);
        $task->wait_time = $request->input('wait_time', 0);
        $task->res_urls = json_encode($res_urls);
        $task->save();

        if($user->role == 'user'){
            $user->balance -= 1;
            $user->save();
        }

        return redirect()->to('/task/' . $task->id);

    }


    public function task_load($id)
    {

        $task = Task::findOrFail($id);

        if ($task->status == 'finished') {
            $reports = Report::where('task_id', $task->id)->orderBy('id', 'asc')->get();
            $csv = 'num;intensity -req/min ;work time - ns;speed download b/ns;codes' . "\n";
            //print_r(count($reports));
            $num = 1;
            foreach ($reports as $report) {
                $csv .= $num++ . ";" . $report->intensity . ";" . $report->work_time . ";" . $report->speed_download . ";";
                $codes = json_decode($report->codes_requests);
                foreach ($codes as $сode => $count) {
                    $csv .= $сode . ";" . $count . ";";
                }
                $csv .= "\n";
            }
            //echo $csv;
            //'Content-Disposition: attachment; filename="Image.png"'
            //return response($csv)->header('Content-Type', $type);
            $fname = 'report-' . $task->start . '-id-' . $task->id . '.csv';
            $fname = str_replace(' ', '_', $fname);
            return response($csv)->header('Content-Disposition', 'attachment; filename="' . $fname . '"');
        }
        //return redirect()->to('/task/' . $task->id);

    }

    public function task_start($id)
    {

        $task = Task::findOrFail($id);

        if ($task->status == 'new') {
            $task->status = 'inprogress';
            $task->start = Carbon::now()->toDateTimeString();
            $task->save();
            /** отправляем задачу для выполнения на сервер*/
            $workTask = new RequestTask();
            $workTask->action = 'add';
            $workTask->mainUrl = $task->main_url;
            $workTask->taskId = $task->id;
            $workTask->taskPerMin = $task->intensity;
            $workTask->res = json_decode($task->res_urls);
            $workTask->workTime = $task->work_time;
            $workTask->type = $task->type;
            $workTask->intensityStep = $task->intensity_step;
            $workTask->waitTime = $task->wait_time;

            $workTask->logGenPeriod = 5;
            try {
                $this->sendTask(json_encode($workTask));
            } catch (\Exception $e) {
                $task->status = 'error';
                $task->save();
            }
        }
        return redirect()->to('/task/' . $task->id);

    }


    /** обновляет репорт для задаче  в интерфейсе json*/
    public function get_task_reports_json(Request $request, $id)
    {

        if ($request->has('update')) {
            $task = Task::find($id);
            if ($task->status === 'finished') {
                return 'stop';
            }
        }

        $reports = Report::where('task_id', $id)->where('users_request', '>', 0)->orderBy('id', 'asc')->get();

        return json_encode($reports);
    }


    /** обновляет репорт для задаче  в интерфейсе*/
    public function get_task_report(Request $request, $id)
    {

        if ($request->has('update')) {
            $task = Task::find($id);
            if ($task->status === 'finished') {
                return 'stop';

            }
        }

        $reports = Report::where('task_id', $id)->get();
        $table = "";
        foreach ($reports as $report) {

            $table .= "
            <tr>
                        <td>  $report->id  </td>
                        <td>  $report->users_send  </td>
                        <td>  $report->users_request  </td>
                        <td>  $report->all_request  </td>
                        <td>  $report->work_time  </td>
                        <td>
                        <table class=\"table table-hover\">
                        <th>Ответ</th>
                        <th>Количество</th>";
            $codes_requests = json_decode($report->codes_requests);
            foreach ($codes_requests as $k => $v) {
                $table .= "<tr>
                        <td> $k </td>
                        <td> $v </td>
                        </tr>";
            }
            $table .= "</table>
                        </td>
                        </tr>";
        }


        return $table;
    }


    /** обновляет репорт для задаче  по запросу */
    public function set_task_report($id)
    {
        $task = new RequestTask();
        $task->action = 'log';
        $task->taskId = $id;
        $resp = $this->sendTask(json_encode($task));
        $reports = json_decode($resp);
        if ($resp != 'stop') {
            foreach ($reports as $num => $report) {
                if (Report::where('task_id', $report->task_id)->where('num', $num)->count() == 0) {
                    $dbReport = new Report();
                    $dbReport->task_id = $report->task_id;
                    $dbReport->users_send = $report->users_send;
                    $dbReport->users_request = $report->users_request;
                    $dbReport->all_request = $report->all_request;
                    $dbReport->work_time = $report->work_time;
                    //$dbReport->speed_upload = $report->upload_speed;
                    $dbReport->speed_download = $report->download_speed;
                    $dbReport->codes_requests = json_encode($report->codes_requests);
                    $dbReport->num = $num;
                    $dbReport->save();
                }
            }
        }

        //   {"1":{"task_id":5,"users_send":11,"users_request":11,"all_request":330,"work_time":434,"codes_requests":{"200":330}}}

        return $resp;
    }


    /** возращает репорт по задаче */
    public function get_url_info(Request $request)
    {
        $task = new RequestTask();
        $task->action = 'log';
        $task->task_id = 1;
        $resp = $this->sendTask(json_encode($task));
        return $resp;
    }


    /**
     * получает json строку репорта и созраняет его
     *
     * @param Request $request
     */
    public function save_url_report(Request $request)
    {
        $json_string_report = $request->input('report');
        $json_obj_report = json_decode($json_string_report);


        $report = new Report();
        $report->task_id = $json_obj_report->task_id;
        $report->users_send = $json_obj_report->users_send;
        $report->users_request = $json_obj_report->users_request;
        $report->all_request = $json_obj_report->all_request;
        $report->work_time = $json_obj_report->work_time;
        $report->codes_requests = $json_obj_report->codes_requests;
        $report->save();
    }

    /**
     *
     * создает задачу и запускает ее на выполнение
     *
     * @param Request $request
     * @return string
     */
    public function get_url_static(Request $request)
    {
        /** основной урл */
        $main_url = $request->input('url');
        /** список урлов ресурсов */
        $res_urls = self::get_res($main_url);


        /** создаем задачу и созраняем в базу */
        $newTask = new Task();
        $newTask->main_url = $main_url;
        $newTask->res_urls = $res_urls;
        $newTask->save();

        /** отправляем задачу для выполнения на сервер*/
        $task = new RequestTask();
        $task->action = 'add';
        $task->task_id = $newTask->id;
        $task->main_url = $main_url;
        $task->res = $res_urls;

        /** отправляем задачу на выполнение  */
        self::sendTask(json_encode($task));
        return "start";
    }

    //
    public function sendTask($task)
    {
        return $this->sendData(env('UPTEST_SERVER'), env('UPTEST_PORT'), $task);
    }

    public function sendData($server, $port, $data)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);// socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket, $server, $port);
        $data .= "\n\n";
        $wr = socket_write($socket, $data, strlen($data));


        $out = '';
        $request = '';
        while ($out = socket_read($socket, 2048)) {
            // echo $out;
            $request .= $out;
        }
        return $request;
    }


    public static function get_scripts($content)
    {
        if (preg_match_all("~<script[^>]+src=['\"]([^'\"#]*)['\"][^>]*>~is", $content, $scripts)) {
            return $scripts[1];
        } else {
            return [];
        }
    }

    public static function get_images($content)
    {
        if (preg_match_all("~<img[^>]+src=['\"]([^'\"]*)['\"][^>]*>~is", $content, $imgs)) {
            return $imgs[1];
        } else {
            return [];
        }
    }

    public static function get_css($content)
    {
        if (preg_match_all("~<link(?=[^>]+rel=['\"]stylesheet['\"][^>]*>)[^>]+href=['\"]([^'\"]*)['\"][^>]*>~is", $content, $css)) {
            return $css[1];
        } else {
            return [];
        }
    }


    public static function process_urls(&$urls, $uri)
    {
        foreach ($urls as &$url) {
            $url = self::absoluteUrl($url, $uri['scheme'] . '://' . $uri['host']);
        }
    }

    public static function get_res($url)
    {
        if (is_null($url)) {
            return false;
        }

        $scripts = null;
        $imgs = null;
        $css = null;
        $hrefs = null;


        $uri = parse_url($url);
        //print_r($uri);

        //preg_match("~(?=^.{3,2048}$)^([^\\s:]+://)?([^\\s/?#:]+)(/[^\\s?#]*)?(\\?[^\\s#]*)?(#\\S*)?$~", $url, $uri);
        //print_r($uri);

        $content = file_get_contents($url);

        $scripts = self::get_scripts($content);
        //print_r($scripts);
        self::process_urls($scripts, $uri);
        // print_r($scripts);
        $scripts = preg_grep('~^https?://(?:www\\.)?' . $uri['host'] . '.*$~is', $scripts, 0);
        //print_r($scripts);


        $imgs = self::get_images($content);
        self::process_urls($imgs, $uri);
        $imgs = preg_grep('~^https?://(?:www\\.)?' . $uri['host'] . '.*$~is', $imgs, 0);

        $css = self::get_css($content);
        self::process_urls($css, $uri);
        $css = preg_grep('~^https?://(?:www\\.)?' . $uri['host'] . '.*$~is', $css, 0);

        return array_merge($scripts, $imgs, $css);
    }

    /**
     * Приведение ссылки к абсолютному URI
     *
     * @param string $link ссылка (абсолютный URI, абсолютный путь на сайте, относительный путь)
     * @param string $base базовый URI (можно без "http://")
     * @return string абсолютный URI ссылки
     */
    public static function uri2absolute($link, $base)
    {
        if (!preg_match('~^(http://[^/?#]+)?([^?#]*)?(\?[^#]*)?(#.*)?$~i', $link . '#', $matchesLink)) {
            return false;
        }
        if (!empty($matchesLink[1])) {
            return $link;
        }
        if (!preg_match('~^(http://)?([^/?#]+)(/[^?#]*)?(\?[^#]*)?(#.*)?$~i', $base . '#', $matchesBase)) {
            return false;
        }
        if (empty($matchesLink[2])) {
            if (empty($matchesLink[3])) {
                return 'http://' . $matchesBase[2] . $matchesBase[3] . $matchesBase[4];;
            }
            return 'http://' . $matchesBase[2] . $matchesBase[3] . $matchesLink[3];
        }
        $pathLink = explode('/', $matchesLink[2]);
        if ($pathLink[0] == '') {
            return 'http://' . $matchesBase[2] . $matchesLink[2] . $matchesLink[3];
        }
        $pathBase = explode('/', preg_replace('~^/~', '', $matchesBase[3]));
        if (sizeOf($pathBase) > 0) {
            array_pop($pathBase);
        }
        foreach ($pathLink as $p) {
            if ($p == '.') {
                continue;
            } elseif ($p == '..') {
                if (sizeOf($pathBase) > 0) {
                    array_pop($pathBase);
                }
            } else {
                array_push($pathBase, $p);
            }
        }
        return 'http://' . $matchesBase[2] . '/' . implode('/', $pathBase) . $matchesLink[3];
    }

    public static function absoluteUrl($rel, $base)
    {
        if (parse_url($rel, PHP_URL_SCHEME) != '')
            return $rel;
        if ('' == $rel)
            return $rel;
        if ($rel[0] == '#' or $rel[0] == '?')
            return $base . $rel;
        extract(parse_url($base));
        if (strpos($rel, '//') === 0)
            return $scheme . ':' . $rel;
        if (isset($path)) {
            $path = preg_replace('~/[^/]*$~', '', $path);
        } else {
            $path = '/';
        }
        if ($rel[0] == '/')
            $path = '';
        $abs = "$host$path/$rel";
        $re = array('~/\.?/~', '~/(?!\.\.)[^/]+/\.\./~');
        for ($n = 1; $n > 0; $abs = preg_replace($re, '/', $abs, -1, $n)) {
        }
        return $scheme . '://' . $abs;
    }
}
