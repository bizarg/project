<?php

namespace Tests;

class ApiHelper
{
    public static function checkResponse($error, $response)
    {
        if (is_null($response)) {
            return null;
        }

        if (isset($response->error)) {
            if (is_array($response->error)) {
                return in_array($error, $response->error);
            } else {
                return $error == $response->error;
            }
        }

        return false;
    }

    public static function checkMessageType($error, $response)
    {
        if (is_null($response)) {
            return null;
        }

        if (is_array($response)) {
            foreach ($response as $res) {
                if($error == $res->type) return true;
            }
        }

        return false;
    }
}