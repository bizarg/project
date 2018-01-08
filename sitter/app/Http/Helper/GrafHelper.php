<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 23.02.2017
 * Time: 12:28
 */

namespace App\Http\Helper;


class GrafHelper
{
    static public function getColorGradient($min, $max, $val)
    {

        $diff = (float)$max - (float)$min;
        if ($diff == 0)
            $diff = 1;
        $n = 100 * ((float)$val - $min) / $diff;
        $R = (255 * $n) / 100;
        $G = (255 * (100 - $n)) / 100;
        $B = 0;
        return self::rgb2hex([$R, $G, $B]);

    }

    static public function getColor($val)
    {

        if ($val <= 1) {
            return self::rgb2hex([0, 255, 0]);
        } elseif ($val > 1 && $val <= 2) {
            return self::rgb2hex([255, 255, 0]);
        } elseif ($val > 2 && $val <= 3) {
            return self::rgb2hex([255, 0, 0]);
        } else {
            return self::rgb2hex([0, 0, 0]);
        }


    }

    static public function rgb2hex($rgb)
    {
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

        return $hex; // returns the hex value including the number sign (#)
    }

}