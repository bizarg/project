<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'url',
        'domain',
        'ip',
        'user_id',
        'node_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function node()
    {
        return $this->belongsTo('App\Node');
    }
}
