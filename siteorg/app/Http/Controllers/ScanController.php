<?php

namespace App\Http\Controllers;


use App\Builders\AlexaBuilder;
use App\Builders\FBBuilder;
use App\Builders\GoogleAnalizeBuilder;
use App\Builders\GoogleIndexBuilder;
use App\Builders\GoogleParamsBuilder;
use App\Builders\LiveInternetBuilder;
use App\Builders\MainInfoBuilder;
use App\Builders\ScreenShotBuilder;
use App\Builders\SSLBuilder;
use App\Builders\StatusBuilder;
use App\Builders\VirusBuilder;
use App\Builders\VKBuilder;
use App\Builders\YandexIndexBuilder;
use App\Exceptions\ScannerException;
use App\Facades\SiteManager;
use App\Rospotrebnadzor;
use App\Scanners\AlexaScanner;
use App\Scanners\FBScanner;
use App\Scanners\GoogleScanner;
use App\Scanners\LiveInternetScanner;
use App\Scanners\MainScanner;
use App\Scanners\RoskomnadzorScanner;
use App\Scanners\ScreenShotScanner;
use App\Scanners\SSLScanner;
use App\Scanners\StatusScanner;
use App\Scanners\VirusesScanner;
use App\Scanners\VKScanner;
use App\Scanners\YandexScanner;
use App\Site;
use App;
use App\Types\Error;
use App\Types\InfoType;
use App\Types\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class ScanController extends Controller
{
    public function get_domain_info(Request $request)
    {
        $need_update = false;
        if (!$request->has('type')) {
            $request->type = InfoType::main_info;
        }

        $messages = [
            'required' => Error::domain_required,
            'min' => Error::domain_length_min,
            'domain.max' => Error::domain_length_min,
            'regex' => Error::domain_name_error,
        ];

        $validator = Validator::make($request->all(), [
            'domain' => 'required|min:4|max:255',
            'update' => 'boolean'
        ], $messages);

        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }

        $site = Site::where('domain', $request->domain)->first();
        if (empty($site)) {
            $site = new Site;
            $site->domain = $request->domain;
            $site->save();
        }


        if (isset($data['update'])) {
            $need_update = $data['update'];
        }

        $response = self::scan($site, $request->type, $need_update);

        return response()->json($response);
    }


    public static function get_domain_info_period(Site $site, $type, $from)
    {
        $object = null;
        $response = [];

        try {
            $object = SiteManager::getMonitor($type);
            $array = $object['class']::where('site_id', $site->id)->where('updated_at', '>=', $from)->get();
            foreach ($array as $obj) {
                $response[] = $obj->build();
            }
        } catch (\Exception $ex) {
            $response['error'] = [Error::info_type_not_support];
        }

        //        switch ($type) {
//            case InfoType::screenshot:
//                $object = 'ScreenShot';
//                break;
//            case InfoType::status:
//                $object = 'Status';
//                break;
//            case InfoType::yandex_index:
//                $object = 'YandexIndex';
//                break;
//            case InfoType::alexa:
//                $object = 'AlexaRank';
//                break;
//            case InfoType::liveinternet:
//                $object = 'LiveInternet';
//                break;
//            case InfoType::google_pr:
//                $object = 'GooglePR';
//                break;
//            case InfoType::google_index:
//                $object = 'GoogleIndex';
//                break;
//            case InfoType::vk_likes:
//                $object = 'VK';
//                break;
//            case InfoType::fb_likes:
//                $object = 'FB';
//                break;
//            default:
//                $response['error'] = [Error::info_type_not_support];
//
//        }
//        if (isset($object)) {
//            $object = 'App\\' . $object;
//            $array = $object::where('site_id', $site->id)->where('updated_at', '>=', $from)->get();
//            foreach ($array as $obj) {
//                $response[] = $obj->build();
//            }
//        }


        return $response;
    }

    /**
     * @param $site
     * @param $type
     * @param $update
     * @return \App\Status|array
     */
    public static function scan($site, $type, $update)
    {
        $response = null;


        try {
            $object = SiteManager::scan($site, $type, $update);
            $response = $object->build();
        } catch (ScannerException $response) {
            $response['error'] = $response->getError();
        } catch (\Exception $ex) {
            Log::error($ex);
            $response['error'] = [Error::unknown_error];
        }

        return $response;

    }

}
