<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'name', 'tariff_id', 'user_id', 'status_id'
    ];

    public function tariff()
    {
        return $this->belongsTo('App\Tariff');
    }

    public  function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
