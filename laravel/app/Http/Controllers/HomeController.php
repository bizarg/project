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
use App\Ticket;

use App\Http\Payment\CreatePayment;
use App\Http\Payment\ResponsePayment;


class HomeController extends Controller
{
//    Чижевский Александр Александрович
//      5168755622142236
//      08/19
//      860
    private $merchantAccount = "test_merch_n1";
    private $merchantSecretKey = "flk3409refn54t54t*FNJRET";
    private $MerchantDomainName = 'http://workplace2.websitter.org:81';

    public function creatpay(Request $request)
    {

        $orderDate = time();
        $user = Auth::user();

        $orderReference =  Ticket::create([
            'name' => $orderDate,
            'description' => $orderDate,
            'status' => 0,
            'user_id' => $user->id
        ]);

        $order = new CreatePayment($this->merchantAccount, $this->merchantSecretKey);

        $order->addProduct("пополнение баланса",$request->value, 1)
            ->setMerchantDomainName($this->MerchantDomainName)
            ->setOrderReference($orderReference->description)
            ->setOrderDate($orderDate)
            ->setAmount(1)
            ->setCurrency('UAH')
            ->setServiceUrl($this->MerchantDomainName.'/result')
            ->setClientEmail('spfhu@rambler.ru')
            ->setClientPhone(380934074302)
            ->setReturnUrl($this->MerchantDomainName.'/payed');

        return view('welcomew', compact('order'));
    }

    public function payed(Request $request)
    {
        if($request->reason == 'Ok'
            && $request->transactionStatus == 'Approved'
            && $request->reasonCode == 1100){

            $ticket = Ticket::where('description', $request->orderReference)->first();

            if($ticket->description == $request->orderReference){
                $ticket->status = 1;
                $ticket->save();

                return redirect(route('home'))->with('successfully', 'Your money added at your balance' );
            }
        }

        return 'false';
    }

    public function showpay()
    {
        $ticket = Ticket::where('description', 1492072259)->first();
        dump($ticket);
//        dump($ticket[0]->name);
//        dump($ticket[0]->description);
//        dump($ticket[0]->user_id);die;
    }

    public function validpay(Request $request)
    {
        $response = new ResponsePayment($this->merchantAccount, $this->merchantSecretKey);

        if($response->validation()){
            $signature = $response->generateMerchantSignature();
            $ticket = Ticket::where('description', $request->orderReference)->get();
            return response()->json([
                'orderReference' => $ticket->description,
                'status' => 'accept',
                'time' => $ticket->orderDate,
                'signature' => hash_hmac('md5',$signature, $this->merchantSecretKey)
            ]);



        }




    }

    public function wayforpayResponse(Request $request)
    {
        $response = new ResponsePayment($this->merchantAccount, $this->merchantSecretKey);

        return $response->validation();
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user = Auth::user();

//        $user_domains = $this->getApiconnector()->domains();
//        foreach ($user_domains as &$user_domain) {
//
//            if ($user_domain->domain_status ) {
//
//                $user_domain->info = $this->getApiconnector()->domain_info($user_domain->domain);
//
//                $user_domain->availablity = $this->getApiconnector()
//                    ->domain_param_history($user_domain->domain, 'download', Carbon::now()->subDay()->toDateString());
//
//                $min = null;
//                $max = null;
//                $colors = '';
//                $availability = '';
//
//                if (is_array($user_domain->availablity)) {
//                    $user_domain->availablity = array_reverse($user_domain->availablity);
//                    foreach ($user_domain->availablity as $av) {
//                        $obj = json_decode($av->value);
//                        $colors .= '\'' . GrafHelper::getColor($obj->time) . '\',';
//                        $availability .= $obj->time . ',';
//                    }
//                }
//
//                $user_domain->availablity = $availability;
//                $user_domain->colors = $colors;
//                $user_domain->notify = $this->getApiconnector()->domain_notify($user_domain->domain);
//            }
//
//        }
//
//        return view('home', ['domains' => $user_domains, 'user' => $user]);
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
//                        $message->to('spfhu@rambler.ru')->subject('Deadline');
//                    });
//                    $date->msg_day = 1;
//                    $date->save();
//                }
//            }
//
//            if ($date->date < $week) {
//                if (!$date->msg_week) {
//                    Mail::queue('emails.deadline', array('date' => $date, 'day' => 7), function ($message) {
//                        $message->to('spfhu@rambler.ru')->subject('Deadline');
//                    });
//                    $date->msg_week = 1;
//                    $date->save();
//                }
//            }
//        }
//    }
}
