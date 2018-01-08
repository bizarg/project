<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{

    protected $fillable = [
        'ip',
        'port',
        'login',
        'password',
        'type',
        'status',
        'banned',
        'text'
    ];
}
