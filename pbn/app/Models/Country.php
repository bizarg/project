<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];
    protected $table = 'countries';

    public function servers()
    {
        return $this->hasMany('App\Models\Server');
    }
}
