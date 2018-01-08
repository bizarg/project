<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = ['name', 'description', 'user_id'];

	public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function assistants()
	{
		return $this->belongsToMany('App\User');
	} 

	public function domens()
	{
		return $this->belongsToMany('App\Domen')->withPivot('priority', 'updated_at')->withTimestamps();
	}

	public function logs()
	{
		return $this->morphMany('App\Log', 'logable');
	}

	public function tasks()
	{
		return $this->morphMany('App\Task', 'taskable');
	}
}
