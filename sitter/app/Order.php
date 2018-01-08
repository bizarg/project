<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'url', 'tariff', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
