<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replanish extends Model
{
    protected $table = 'replanishes';

    protected $fillable = [
        'user_id', 'amount'
    ];
}
