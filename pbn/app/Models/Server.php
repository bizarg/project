<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = ['ip', 'country_id', 'domain_id'];
    protected $table = 'servers';

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function domains()
    {
        return $this->hasMany('App\Models\Domain');
    }

//    public function city()
//    {
//        return$this->hasOne('App\Models\City');
//    }
}
