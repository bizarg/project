<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'port',
        'country',
        'flag',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getNodeName()
    {
        return $this->country . ' / ' . $this->city . ' / ' . $this->dc;
    }
}
