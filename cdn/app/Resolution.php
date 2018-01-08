<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resolution extends Model
{
    protected $table = 'resolutions';

    protected $fillable = [
        'weight', 'height'
    ];
}
