<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'date', 'status', 'taskable_id', 'taskable_type'];
	
	public function taskable()
	{
		return $this->morphTo();
	}

	public function comments()
	{
		return $this->morphMany('App\Comment', 'commentable');
	}
}
