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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function project()
    {
        return $this->hasOne('App\Project');
    }

    public function domens()
    {
        return $this->hasMany('App\Domen');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function tickets()
    {
        return $this->belongsTo('Kordy\Ticketit\Models\Ticket', 'ticket_id');
    }

    public function domains()
    {
        return $this->hasMany('App\Domain');
    }

//    public function getBalanceAttribute($value)
//    {
//        return number_format($value, 2);
//    }

    public function canDo($permission, $require = FALSE)
    {
        if(is_array($permission)){
            foreach($permission as $permName){
                $permName = $this->canDo($permName);
                if($permName && !$require){
                    return TRUE;
                }
                else if(!$permName && $require){
                    return FALSE;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $role){
                foreach($role->permissions as $perm){
                    if(str_is($permission, $perm->name)){
                        return TRUE;
                    }
                }
            }
        }
    }
}
