<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = ['text', 'commentable_id', 'commentable_type', 'user_id', 'user_name'];
	
	public function commentable()
	{
		return $this->morphTo();
	}
}
