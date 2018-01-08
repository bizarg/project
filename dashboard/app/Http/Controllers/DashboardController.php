<?php

namespace App\Http\Controllers;

use App\Http\Api\ApiConnector;
use App\Http\Api\PiwikHelper;
use App\Http\Helpers\GrafHelper;
use App\Http\Helpers\DataHelper;
use App\Http\Helpers\PaginateHelper;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Validator;
use App\Types\InfoType;
use App\Types\Error;
use Lang;

class DashboardController extends Controller
{
    private $apiconnector;

    private function getApiconnector()
    {
        if (!isset($this->apiconnector)) {
            $this->apiconnector = ApiConnector::getInstance();
            $this->apiconnector->setAuthKey(Auth::user()->api_key);
            $this->apiconnector->setApiUrl(env('API_URL'));
        }
        return $this->apiconnector;
    }

    public function test_token()
    {
        Artisan::call('generate:token', ['email' => 'new12@user.com', 'amhost_id' => '12', 'amhost_login' => '12']);
//        Artisan::call('generate:token', ['email' => 'fix@mail.net', 'amhost_id' => '87', 'amhost_login' => '87']);
    }

    public function main(Request $request)
    {
        $user_domains = $this->getApiconnector()->get_user_domains();

        if (is_null($user_domains) || isset($user_domains->error)) {
            $items = [];
        } else {
            $items = PaginateHelper::getItems($request, $user_domains);
        }

        foreach ($items as &$user_domain) {

//            $user_domain->yandex_index = $this->getApiconnector()
//                ->get_domain_info($user_domain->domain, InfoType::yandex_index);
//            $user_domain->google_index = $this->getApiconnector()
//                ->get_domain_info($user_domain->domain, InfoType::google_index);
//            $user_domain->alexa = $this->getApiconnector()
//                ->get_domain_info($user_domain->domain, InfoType::alexa);
            $user_domain->notify = DataHelper::getMessages($this->getApiconnector()->domain_messages($user_domain->domain));

            $user_domain->availablity = $this->getApiconnector()
                ->get_domain_info_period($user_domain->domain, InfoType::status, Carbon::now()->subDay()->toDateString());

            if ($user_domain->availablity) {
                $min = null;
                $max = null;
                $colors = '';
                $availability = '';

                if (is_array($user_domain->availablity)) {
                    $user_domain->availablity = array_reverse($user_domain->availablity);

                    foreach ($user_domain->availablity as $av) {

                        $time = DataHelper::getTime($av) ;

                        $availability .= $time . ',';
                        $colors .= '\'' . GrafHelper::getColor($time) . '\',';
                    }
                }

                $user_domain->availablity = $availability;
                $user_domain->colors = $colors;
            } else {
                $user_domain->availablity = '';
                $user_domain->colors = '';
            }
        }
//die;
        if (count($items)) {
            if ($request->has('search')) {
                $items = PaginateHelper::getPaginate(
                    $items,
                    count(PaginateHelper::getSearchResult($user_domains, $request->search))
                );
                $items->setPath('/?search=' . $request->search);

            } else {
                $items = PaginateHelper::getPaginate($items, count($user_domains));
            }
        }

        return view('dashboard', ['domains' => $items]);
    }

    public function domain_seo($domain_name)
    {
        $domain_params = $this->getApiconnector()->get_domain_info($domain_name, InfoType::alexa);

        if(is_null($domain_params) || isset($domain_params->error)) {
            $domain_params = [];
        } else {
            $domain_params->alexa_traffic = json_decode($domain_params->traffic);
        }

        $gid = ['indexes' => '', 'labels' => ''];
        $yid = ['indexes' => '', 'labels' => ''];

        $gi = $this->apiconnector->get_domain_info_period(
            $domain_name,
            InfoType::google_index,
            Carbon::now()->subYear()->toDateString()
        );

        if(is_null($gi) || isset($gi->error)) $gi = [];

        foreach ($gi as $param) {
            $gid['indexes'] .= $param->index . ', ';
            $gid['labels'] .= "'" . $param->created_at->date . '\',';
        }

        $yi = $this->apiconnector->get_domain_info_period(
            $domain_name,
            InfoType::yandex_index,
            Carbon::now()->subYear()->toDateString()
        );

        if(is_null($yi) || isset($yi->error)) $yi = [];

        foreach ($yi as $param) {
            $yid['indexes'] .= $param->index . ', ';
            $yid['labels'] .= "'" . $param->created_at->date . '\',';
        }

        return view('seo', ['params' => $domain_params, 'domain' => $domain_name, 'gi' => $gid, 'yi' => $yid]);
    }

    public function confirm_info($domain, $id)
    {
        $domains = $this->getApiconnector()->get_user_domains();

        if(is_null($domains) || isset($domain->error)){
            abort(500);
        }

        $d = null;
        $info = '';

        foreach ($domains as $domain) {
            if ($domain->id == $id) {
                $d = $domain;
                break;
            }
        }
        if ($d !== null) {
            $info = ($d->hash) ? $d->hash : 'null';
        }

        return view('confirm', ['info' => $info, 'domain' => $domain, 'id' => $id]);
    }

    public function confirm($id)
    {
        $api_response = $this->getApiconnector()->domain_confirm($id);

        if (isset($api_response->error)) {
            return redirect()->back()->withErrors(DataHelper::getMessages($api_response));
        } else {
            return redirect('/');
        }
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

        $response = $this->getApiconnector()
            ->add_domain_to_user(preg_replace('/^(https?:\/\/)/i', '',$request->domain));

        if (is_null($response)) {
            return redirect('/')->with('fail', 'Domain has not been added');
        }

        if (isset($response->error)) {
            return redirect()->back()
                ->withErrors(DataHelper::getMessages($response))
                ->withInput();
        } else {
            return redirect('/')->with('success', 'Domain has been added');
        }
    }

    public function domain_info($domain_name)
    {
        set_time_limit(0);
        $statuses = $this->getApiconnector()->get_domain_info_period(
            $domain_name,
            'status',
            Carbon::now()->subMonth()->toDateString()
        );

        $piwikhelper = PiwikHelper::getInstance();
        $min = null;
        $max = null;
        $colors = '';
        $availability = '';
        $labels = '';
        $graphicname = null;

        $piwikids = $piwikhelper->getSitesIdFromSiteUrl($domain_name);

        if (!empty($piwikids)) {
            $imgcont = $piwikhelper->imageGraphget($piwikids[0]->idsite);
            $graphicname = $domain_name . '.jpg';
            Storage::disk('graphics')->put($graphicname, $imgcont);
        }

        if (is_array($statuses)) {
            $statuses = array_reverse($statuses);

            foreach ($statuses as $av) {

                $time = DataHelper::getTime($av) ;

                $availability .= $time . ',';
                $colors .= '\'' . GrafHelper::getColor($time) . '\',';
                $labels .= "'{$av->created_at->date}',";
            }
        }

        if (!isset($statuses)) $statuses = [];

        return view('monitoring', [
            'labels' => $labels,
            'statuses' => $statuses,
            'colors' => $colors,
            'availablity' => $availability,
            'domain' => $domain_name,
            'graphicname' => $graphicname
        ]);
    }

    public function add_piwik($domain)
    {
        $piwikhelper = PiwikHelper::getInstance();
        $response = $piwikhelper->addDomains($domain);
        return response()->json($response);
    }

    public function faq()
    {
        return view('faq');
    }

    public function settings()
    {
        return view('settings');
    }

    public function delete($id)
    {
        $this->getApiconnector()->domain_delete($id);
    }

    public function get_index(Request $request)
    {
        $user_domain = json_decode($request->id);

        if ($user_domain->confirm == 'not_confirm') {
            $user_domain->notify = [];
            return response()->json($user_domain);
        }

        $user_domain->yandex_index = $this->getApiconnector()
            ->get_domain_info($user_domain->domain, InfoType::yandex_index);

        $user_domain->google_index = $this->getApiconnector()
            ->get_domain_info($user_domain->domain, InfoType::google_index);

        $user_domain->alexa = $this->getApiconnector()
            ->get_domain_info($user_domain->domain, InfoType::alexa);

        $user_domain->notify = DataHelper::getMessages($this->getApiconnector()->domain_messages($user_domain->domain));

        return response()->json($user_domain);
    }

    public function get_domains(Request $request)
    {
        $user_domains = $this->getApiconnector()->get_user_domains();

        if (is_null($user_domains) || isset($user_domains->erorr)) return response(['error' => $user_domains], 422);

        foreach ($user_domains as $user_domain) {
            if (in_array($user_domain->id, json_decode($request->id))) {

                $arrayDomain[] = [
                    'id' => $user_domain->id,
                    'domain' => $user_domain->domain,
                    'confirm' => $user_domain->confirm
                ];
            }
        }

        return response()->json($arrayDomain);
    }
}