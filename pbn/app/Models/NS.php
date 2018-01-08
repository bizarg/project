<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NS extends Model
{
    protected $fillable = ['name'];
    protected $table = 'n_s';

    public function domains()
    {
        return $this->hasMany('App\Models\Domain');
    }
}
