<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 25.05.2017
 * Time: 8:52
 */

namespace App\Types;


class MessageType
{
    const google_index = 'google_index';
    const yandex_index = 'yandex_index';
    const roskomnadzor = 'roskomnadzor';
    const ssl_expire = 'ssl_expire';
    const unavailable = 'unavailable';
    const virus_found = 'virus_found';
    const domain_expire = 'domain_expire';
    const domain_expire_not_foud = 'domain_expire_not_foud';



    public static function getLevel($type)
    {
        $level = Level::Livel1;

        switch ($type) {
            case MessageType::google_index:
                $level = Level::Livel2;
                break;
            case MessageType::roskomnadzor:
                $level = Level::Livel4;
                break;
            case MessageType::ssl_expire:
                $level = Level::Livel3;
                break;
            case MessageType::unavailable:
                $level = Level::Livel4;
                break;
            case MessageType::domain_expire:
                $level = Level::Livel4;
                break;
            case MessageType::domain_expire_not_foud:
                $level = Level::Livel4;
                break;
            case MessageType::virus_found:
                $level = Level::Livel4;
                break;
            case MessageType::yandex_index:
                $level = Level::Livel1;
                break;
        }
        return $level;
    }
}