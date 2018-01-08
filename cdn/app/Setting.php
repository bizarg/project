<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    	'domain', 'link_format', 'user_id'
    ];

    public function user()
	{
		return $this->belongsTo('App\User');
	} 
}
