<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'quantity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the files for the user.
     * @author Ruslan Ivanov
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function settings()
    {
        return $this->hasMany('App\Settings');
    }

    public function patterns()
    {
        return $this->hasMany('App\Template');
    }
}
