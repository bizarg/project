<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    protected $fillable = ['name'];
    protected $table = 'builds';

    public function domain()
    {
        return $this->hasMany('App\Models\Domain');
    }
}
