<?php

namespace App\Http\Controllers;

use App\Http\API\ApiConnector;
use App\Http\API\PiwikHelper;
use App\Http\Helper\GrafHelper;
use App\User;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Validator;
use App\Tariff;


class DashboardController extends Controller
{


    private $apiconnector;


    private function getApiconnector()
    {

        if (!isset($this->apiconnector)) {
            $this->apiconnector = ApiConnector::getInstance();
            // $this->apiconnector->setAuthKey(Auth::user()->api_key);
            $this->apiconnector->getAuthKey();
        }
        return $this->apiconnector;

    }

    public function test_token()
    {
        Artisan::call('generate:token', ['email' => 'yaroslav@new-wind.biz', 'amhost_id' => '110', 'amhost_login' => '1']);
    }

    public function main()
    {

        $tariffs = Tariff::limit(3)->get();
        $user = Auth::user();

        $user_domains = null;

        $user_domains = $this->getApiconnector()->domains();

        if($user_domains){
            foreach ($user_domains as &$user_domain) {

                if ($user_domain->domain_status ) {

                    $user_domain->info = $this->getApiconnector()->domain_info($user_domain->domain);

                    $user_domain->availablity = $this->getApiconnector()
                        ->domain_param_history($user_domain->domain, 'download', Carbon::now()->subDay()->toDateString());

                    $min = null;
                    $max = null;
                    $colors = '';
                    $availability = '';
                    if (is_array($user_domain->availablity)) {
                        $user_domain->availablity = array_reverse($user_domain->availablity);
                        foreach ($user_domain->availablity as $av) {
                            $obj = json_decode($av->value);
                            $colors .= '\'' . GrafHelper::getColor($obj->time) . '\',';
                            $availability .= $obj->time . ',';
                        }
                    }
                    $user_domain->availablity = $availability;
                    $user_domain->colors = $colors;
                    $user_domain->notify = $this->getApiconnector()->domain_notify($user_domain->domain);
                }
            }
        }



        return view('home', ['domains' => $user_domains, 'user' => $user, 'tariffs' => $tariffs]);

    }


    public function domain_info($domain_name)
    {

        set_time_limit(0);
        $param_download = $this->getApiconnector()->domain_param_history($domain_name, 'download', Carbon::now()->subMonth()->toDateString());

        $piwikhelper = PiwikHelper::getInstance();

        $min = null;
        $max = null;
        $colors = '';
        $availability = '';
        $labels = '';
        $graphicname = null;
        $piwikids = $piwikhelper->getSitesIdFromSiteUrl($domain_name);

        // if (!empty($piwikids)) {
        //     $imgcont = $piwikhelper->imageGraphget($piwikids[0]->idsite);
        //     $graphicname = $domain_name . '.jpg';
        //     Storage::disk('graphics')->put($graphicname, $imgcont);

        // }
        if (is_array($param_download)) {
            $param_download = array_reverse($param_download);
            foreach ($param_download as $av) {
                $obj = json_decode($av->value);
                $colors .= '\'' . GrafHelper::getColor($obj->time) . '\',';
                $availability .= $obj->time . ',';
                $labels .= "'$av->date',";
            }
        } else {
            abort(404);
        }

        $statuses = $this->apiconnector->domain_param_history($domain_name, 'status', Carbon::now()->subMonth()->toDateString());

        if (!isset($statuses)) {
            $statuses = [];
        }


        return view('monitoring', ['labels' => $labels, 'statuses' => $statuses, 'colors' => $colors, 'availablity' => $availability, 'domain' => $domain_name, 'graphicname' => $graphicname]);

    }

    public function domain_seo($domain_name)
    {
        $domain_params = $this->getApiconnector()->domain_info($domain_name);
        $domain_params->alexa_trafic = json_decode($domain_params->alexa_trafic);

        $gid = ['indexes' => '', 'labels' => ''];
        $yid = ['indexes' => '', 'labels' => ''];

        $gi = $this->apiconnector->domain_param_history($domain_name, 'g_index', Carbon::now()->subYear()->toDateString());
        foreach ($gi as $param) {

            $gid['indexes'] .= $param->value . ', ';
            $gid['labels'] .= "'" . $param->date . '\',';
        }


        $yi = $this->apiconnector->domain_param_history($domain_name, 'ya_index', Carbon::now()->subYear()->toDateString());
        foreach ($yi as $param) {

            $yid['indexes'] .= $param->value . ', ';
            $yid['labels'] .= "'" . $param->date . '\',';
        }

        return view('seo', ['params' => $domain_params, 'domain' => $domain_name, 'gi' => $gid, 'yi' => $yid]);

    }

    public function settings()
    {

        return view('settings');

    }


    public function add_domain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $response = $this->getApiconnector()->domain_add($request->domain);

        if (empty($response)) {
            abort(505);
        }

        if (isset($response->error)) {

            return redirect()->back()
                ->withErrors($response->error)
                ->withInput();

        } else {
            return redirect('/');
        }
    }


    public function confirm($domain)
    {
        $api_response = $this->getApiconnector()->confrim_domain($domain);
        
         if (isset($api_response->error)) {
            return redirect()->back()->withErrors($api_response->error);
        } else {
            return redirect('/');
        }
    }

    public function confirm_info($domain)
    {
        $info = $this->getApiconnector()->domain_info($domain);
        if (isset($api_response->error)) {
            return redirect()->back()->withErrors($api_response->error);
        }
        return view('confirm', ['info' => $info, 'domain' => $domain]);
    }


    public function add_piwik($domain)
    {

        $piwikhelper = PiwikHelper::getInstance();
        $response = $piwikhelper->addDomains($domain);
         return response()->json($response);
    }

    public function faq() {
        return view('faq');
    }


}
