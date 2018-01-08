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
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function sites()
    {
        return $this->belongsToMany('App\Site', 'user_sites')->withPivot('confirm', 'status', 'notify_level')/*->using('App\UserSite')*/
            ;
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }


}
