<?php

namespace App\Scanners\Helpers;

class Helper
{

    static public function userDomain(UserSite $userSite)
    {
        return !empty($userSite) && $userSite->confirm != 'not_confirm' && $userSite->status == 'enabled';
    }

}