<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'name', 'value'
    ];

    public function domains()
    {
        return $this->hasMany('App\Domain');
    }
}
