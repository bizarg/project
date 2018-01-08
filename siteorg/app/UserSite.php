<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSite extends Model
{
    protected $table = 'user_sites';

    protected $fillable = ['user_id', 'site_id', 'confirm'];

    public function site()
    {
        return $this->hasOne('App\Site');
    }
}