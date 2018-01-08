<?php

namespace App\Http\Helpers;

use Lang;

class DataHelper
{
    public static function getMessages($notify)
    {
        $message = [];

        if (is_object($notify)) {
            if (isset($notify->error) && is_array($notify->error)) {
                foreach ($notify->error as $error) {
                    $message[] = self::notifyReplace($error);
                }
                return $message;
            } else if (isset($notify->error)) {
                $message[] = self::notifyReplace($notify->error);
                return $message;
            }
        }

        if (is_array($notify) && count($notify)) {
            if(isset($notify['error'])){
                foreach ($notify['error'] as $error) {
                $message[] = self::notifyReplace($error);
                }
                return $message;
            } else {
                foreach ($notify as $error) {
                    $message[] = self::notifyReplace($error['type']);
                }
                return $message;
            }
        }

        return $notify;
    }

    public static function notifyReplace($notify)
    {
        return Lang::get('frontend.' . str_replace('.', '_', $notify));
    }

    public static function getTime($array)
    {
        $n = 0;
        $t = 0;
        $countries = ['US', 'DE', 'CA', 'SG'];

        foreach ($countries as $cauntry) {
            if ($array->{$cauntry}->responseCode == 200) {
                $n++;
                $t += $array->{$cauntry}->time;
            }
        }

        if (!$n) {
            return 0;
        }

        return round((($t / $n) / 1000000000), 3) ;
    }

}