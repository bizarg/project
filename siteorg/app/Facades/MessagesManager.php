<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 15.05.2017
 * Time: 12:46
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class MessagesManager extends Facade{
    protected static function getFacadeAccessor() { return 'notification'; }
}