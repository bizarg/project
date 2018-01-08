<?php

namespace App\Http\Controllers;

use App\Facades\SiteManager;
use App\Message;
use App\Rospotrebnadzor;
use App\Scanners\Helpers\Net;
use App\Site;
use App\Types\Error;
use App\Types\InfoType;
use App\UserSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{


    /**
     * ApiController constructor.
     */
    public function __construct()
    {
    }

    /**
     * Добавление домена пользователю
     * @param Request $request
     * @param domain - обязательный параметр
     * @param registrator - не обязательный
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_domain_to_user(Request $request)
    {
        $user = $request->user;
        $data = $request->data;
        $site = null;
        $response = [];

        Log::debug($data);

        //$site = Site::where('domain', $data['domain'])->first();


        $messages = [
            'required' => Error::domain_required,
            'min' => Error::domain_length_min,
            'domain.max' => Error::domain_length_max,
            'regex' => Error::domain_name_error,
            'registrator.max' => Error::registrator_length_max,
        ];

        $validator = Validator::make($data, [
            //'domain' => 'required|min:4|max:255|regex:/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i',
            'domain' => 'required|min:4|max:255',
            'registrator' => 'max:100'
        ], $messages);


        $validator->after(function ($validator) use ($request, &$site) {
            $site = SiteManager::find_or_create($request->data['domain']);

            if (!isset($site)) {
                $validator->errors()->add('domain', Error::domain_code);
                return;
            }
            $site_user = UserSite::where('confirm', '!=', 'not_confirm')
                ->where('status', 'enabled')
                ->where('site_id', $site->id)
                ->first();
            if (isset($site_user)) {
                if ($site_user->user_id == $request->user->id) {
                    $validator->errors()->add('domain', Error::domain_user_has);
                } else {
                    $validator->errors()->add('domain', Error::domain_user_other_has);
                }
                return;
            }
//            $site_user = UserSite::where('user_id', $request->user->id)
//                ->where('site_id', $site->id)
//                 ->first();
//            if (isset($site_user)) {
//                $validator->errors()->add('domain', Error::domain_user_has);
//            }
        });
        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }

        $userSite = new UserSite;
        $userSite->user_id = $user->id;
        $userSite->site_id = $site->id;
        $userSite->hash = str_random(15);
        $userSite->save();

        $response['success'] = Error::domain_add_success;
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_domain_info(Request $request)
    {
        $user = $request->user;
        $data = $request->data;
        $need_update = false;
        $site = null;
        $response = [];

        if (!isset($data['type'])) {
            $data['type'] = InfoType::main_info;
        }


        $messages = [
            'required' => Error::domain_required,
            'min' => Error::domain_length_min,
            'domain.max' => Error::domain_length_max,
            'type.in' => Error::info_type_not_support,

        ];

        $validator = Validator::make($data, [
            'domain' => 'required|min:4|max:255',
            'update' => 'boolean',
            'type' => ['required', Rule::in(SiteManager::getInfoTypes())],
        ], $messages);

        $validator->after(function ($validator) use ($user, &$data, &$site) {
            $site = SiteManager::find_or_create($data['domain']);
            if (!isset($site)) {
                $validator->errors()->add('domain', Error::domain_code);
            }
        });


        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }

        //$site = $this->add_site($data['domain'], isset($data['main_url']) ? $data['main_url'] : null);

        if (isset($data['update'])) {
            $need_update = $data['update'];
        }
        Log::info($data);

        $response = ScanController::scan($site, $data['type'], $need_update);

        return response()->json($response);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_domain_info_period(Request $request)
    {
        $user = $request->user;
        $data = $request->data;
        $site = null;
        $response = [];

        $messages = [
            'domain.required' => Error::domain_required,
            'from.required' => Error::from_date_required,
            'from.date' => Error::not_valid_date,
            'domain.exists' => Error::domain_not_exist,
            'type.in' => Error::info_type_not_support,

        ];

        $validator = Validator::make($data, [
            'domain' => 'required|exists:sites,domain',
            'from' => 'required|date',
            'type' => ['required', Rule::in(SiteManager::getInfoTypesPeriod())],
        ], $messages);

        $validator->after(function ($validator) use ($user, $data, &$site) {
            if ($validator->errors()->count() == 0) {
                $site = Site::where('domain', $data['domain'])->first();
                $usersite = UserSite::where('site_id', $site->id)
                    ->where('status', 'enabled')
                    ->where('confirm', '!=', 'not_confirm')
                    ->first();
                if (!isset($usersite)) {
                    $validator->errors()->add('domain', Error::domain_user_error);
                }
            }
        });


        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }


        $response = ScanController::get_domain_info_period($site, $data['type'], $data['from']);

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_user_domains(Request $request)
    {
        $user = $request->user;

        $sites = Site::select('sites.id', 'sites.domain', 'sites.main_url', 'user_sites.confirm', 'user_sites.hash')
            ->leftJoin('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->where('user_sites.user_id', $user->id)
            ->where('status', 'enabled')
            ->get();

        return response()->json($sites->toArray());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function domain_confirm(Request $request)
    {
        $user = $request->user;
        $data = $request->data;
        Log::info($data);
        $userSite = null;
        $site = null;
        $messages = [
            'required' => Error::domain_id_required,
        ];


        $validator = Validator::make($data, [
            'id' => 'required',
        ], $messages);

        $validator->after(function ($validator) use ($data, $user, &$userSite, &$site) {
            $site = Site::find($data['id']);
            if (empty($site)) {
                $validator->errors()->add('id', Error::domain_id_not_found);
            } else {
                $userSite = UserSite::where('site_id', $site->id)->where('confirm', '!=', 'not_confirm')->first();
                if (!empty($userSite)) {
                    $validator->errors()->add('id', Error::domain_confirm_error);
                } else {
                    $userSite = UserSite::where('site_id', $site->id)->where('user_id', $user->id)->first();
                    if (empty($userSite)) {
                        $validator->errors()->add('id', Error::domain_user_error);
                    }
                }
            }
        });

        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }
        Log::notice($data);

        $url = 'http://' . $site->domain . '/' . $userSite->hash . '.html';
        $content = @file_get_contents($url);
        Log::notice("url - " . $url . "\n content  - \n" . $content);

        if ($content !== false && strpos($content, $userSite->hash) !== false) {
            $userSite->confirm = 'file';
            $response = 'ok';
        } else {
            $content = Net::getContent($site->main_url);
            if (!empty($content) && strpos($content, $userSite->hash) !== false) {
                $userSite->confirm = 'meta';
                $response = 'ok';
            } else {
                $response['error'] = Error::domain_confirm_error;
            }

        }

        $userSite->save();
        return response()->json($response);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_user_domain(Request $request)
    {
        $user = $request->user;
        $data = $request->data;
        $userSite = null;
        $site = null;
        $messages = [
            'required' => Error::domain_id_required,
        ];

        $validator = Validator::make($data, [
            'id' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }

        $userSite = UserSite::where('site_id', $data['id'])->where('user_id', $user->id)->first();
        if (!is_null($userSite)) {
            $userSite->delete();
        }

        $response = 'ok';
        return response()->json($response);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function domain_messages(Request $request)
    {
        $user = $request->user;
        $data = $request->data;

        $userSite = null;
        $site = null;
        $response = [];
        $messages = [
            'required' => Error::domain_required,
        ];


        $validator = Validator::make($data, [
            'domain' => 'required',
        ], $messages);


        $validator->after(function ($validator) use ($data, $user, &$userSite, &$site) {
            $site = Site::where('domain', $data['domain'])->first();
            if (empty($site)) {
                $validator->errors()->add('domain', Error::domain_not_found);
            } else {
                $userSite = UserSite::where('site_id', $site->id)->where('user_id', $user->id)->where('confirm', '!=', 'not_confirm')->first();
                if (empty($userSite)) {
                    $validator->errors()->add('id', Error::domain_not_confirm);
                }
            }
        });


        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }


        $messages = Message::where('site_id', $site->id)->where('status', 'show')->get();
        foreach ($messages as $message) {
            $response[] = $message->build();
        }
        return response()->json($response);

    }

}
