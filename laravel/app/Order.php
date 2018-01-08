<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'orderReference', 'amount', 'orderDate', 'status', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
