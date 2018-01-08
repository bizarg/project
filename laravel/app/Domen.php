<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domen extends Model
{

	protected $fillable = ['name', 'marker', 'priority'];

	public function user()
	{
		return $this->belongsTo('App\User');
	} 

	public function projects()
	{
		return $this->belongstoMany('App\Project')->withPivot('priority');
	}

	public function logs()
	{
		return $this->morphMany('App\Log', 'logable');
	}

		public function tasks()
	{
		return $this->morphMany('App\Task', 'taskable');
	}

	public function comments()
	{
		return $this->morphMany('App\Comment', 'commentable');
	}
}
