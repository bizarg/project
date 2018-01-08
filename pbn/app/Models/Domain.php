<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name', 'ip_id', 'ns1_id', 'ns2_id'];
    protected $table = 'domains';

    public function ip()
    {
        return $this->hasOne('App\Models\Server');
    }

    public function ns1()
    {
        return $this->belongsTo('App\Models\NS');
    }

    public function ns2()
    {
        return $this->belongsTo('App\Models\NS');
    }

    public function build()
    {
        return $this->belongsTo('App\Models\Build');
    }
}
