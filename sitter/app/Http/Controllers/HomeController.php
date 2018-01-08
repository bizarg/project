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



use Mail;
use App\Mail\Reminder;
use App\Task;



class HomeController extends Controller
{
    private $apiconnector;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    private function getApiconnector()
    {

        if (!isset($this->apiconnector)) {
            $this->apiconnector = ApiConnector::getInstance();
//            $this->apiconnector->setAuthKey(Auth::user()->api_key);
            $this->apiconnector->getAuthKey();
        }
        return $this->apiconnector;

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $user_domains = $this->getApiconnector()->domains();
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

        return view('home', ['domains' => $user_domains, 'user' => $user]);
    }

//    public function send()
//    {
//        $dates = Task::all();
//
//        $day = time() + 60 * 60 * 24;
//        $week = time() + 60 * 60 * 24 * 7;
//
//        foreach ($dates as $date) {
//
//            if ($date->date < $day) {
//                if (!$date->msg_day) {
//                    Mail::queue('emails.deadline', array('date' => $date, 'day' => 1), function ($message) {
//                        $message->to('admin@mail.ru')->subject('Deadline');
//                    });
//                    $date->msg_day = 1;
//                    $date->save();
//                }
//            }
//
//            if ($date->date < $week) {
//                if (!$date->msg_week) {
//                    Mail::queue('emails.deadline', array('date' => $date, 'day' => 7), function ($message) {
//                        $message->to('admin@mail.ru')->subject('Deadline');
//                    });
//                    $date->msg_week = 1;
//                    $date->save();
//                }
//            }
//        }
//    }
}
