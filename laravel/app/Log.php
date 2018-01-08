<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	protected $fillable = ['text', 'logable_id', 'logable_type', 'user_id'];

	public function logable()
	{
		return $this->morphTo();
	}
}
