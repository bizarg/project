<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'sites';

    protected $fillable = [
        'domain', 'main_url'
    ];

    public function mainInfo()
    {
        return $this->hasOne('App\MainInfo');
    }
    public function screenshots()
    {
        return $this->hasMany('App\ScreenShot');
    }
    public function userSites()
    {
        return $this->belongsTo('App\UserSite');
    }
    public function yandex()
    {
        return $this->hasMany('App\Yandex');
    }
}
