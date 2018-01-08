<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dmoz extends Model
{
    protected $table = 'dmoz';


    public function site()
    {
        return $this->belongsTo('App\Site');
    }

}
